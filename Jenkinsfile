pipeline {
  agent {
    dockerfile {
      filename 'Dockerfile'
      args ' --network=docker_default --network-alias=mytodo.niconico.io -e "VIRTUAL_HOST=mytodo.niconico.io"'
    }

  }
  stages {
    stage('SETUP') {
      steps {
        sh '''
          
          mv ./*(DN) /var/www/html/
        '''
      }
    }

    stage('BUILD') {
      parallel {
        stage('build API') {
          steps {
            sh '''
              cd /var/www/html
              composer i
            '''
            withCredentials(bindings: [file(credentialsId: 'MY_TODO_ENV', variable: 'myPrivateEnv')]) {
              sh '''
                cd /var/www/html
                cp "$myPrivateEnv" .env
              '''
            }

            sh '''
              cd /var/www/html
              php artisan key:generate
            '''
            sh '''
              cd /var/www/html
              php artisan migrate
            '''
          }
        }

        stage('build APP') {
          steps {
            sh '''
              cd /var/www/html
              git submodule update --init
            '''
            sh '''
              cd /var/www/html
              cd resources/js/my-todo-react
              npm install
              npm run build
            '''
          }
        }

      }
    }

    stage('Serve application') {
      steps {
        sh '''
          cd /var/www/html
          cd resources/js/my-todo-react
          mv ./build/index.html ${WORKSPACE}/resources/views/
          mv ./build/* ${WORKSPACE}/public/
        '''
        input(message: 'Application is online', ok: 'proceed', id: 'deliver')
      }
    }

  }
}