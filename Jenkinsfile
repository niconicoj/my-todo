pipeline {
  agent {
    dockerfile {
      filename 'Dockerfile'
      args ' --network=default_network --network-alias=mytodo.niconico.io -e "VIRTUAL_HOST=mytodo.niconico.io"'
    }

  }
  stages {
    stage('SETUP') {
      steps {
        sh '''
          mv ./* /var/www/html/
          mv ./.[!.]* /var/www/html/
        '''
      }
    }

    stage('BUILD') {
      parallel {
        stage('build API') {
          steps {
            sh '''
              cd /var/www/html
              composer i --no-progress
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
          mv ./build/index.html /var/www/html/resources/views/
          mv ./build/* /var/www/html/public/
        '''
        input(message: 'Application is online', ok: 'proceed', id: 'deliver')
      }
    }

  }
}