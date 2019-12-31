pipeline {
  agent {
    node {
      label 'myTodoApp'
      customWorkspace '/var/www/html'
    }
  }
  stages {
    stage('BUILD') {
      agent {
        dockerfile {
          filename 'Dockerfile'
          additionalBuildArgs '--no-cache --build-arg WORKSPACE=$WORKSPACE'
          args ' --network=docker_default --network-alias=mytodo.niconico.io -e "VIRTUAL_HOST=mytodo.niconico.io"'
        }
      }
      parallel {
        stage('build API') {
          steps {
            sh 'composer i'
            withCredentials(bindings: [file(credentialsId: 'MY_TODO_ENV', variable: 'myPrivateEnv')]) {
              sh '''
                cp "$myPrivateEnv" .env
              '''
            }

            sh 'php artisan key:generate'
            sh 'php artisan migrate'
          }
        }

        stage('build APP') {
          steps {
            sh 'git submodule update --init'
            sh '''cd resources/js/my-todo-react
npm install
npm run build
            '''
          }
        }

      }
    }

    stage('Serve application') {
      steps {
        sh '''cd resources/js/my-todo-react
mv ./build/index.html ${WORKSPACE}/resources/views/
mv ./build/* ${WORKSPACE}/public/'''
        input(message: 'Application is online', ok: 'proceed', id: 'deliver')
      }
    }

  }
}