pipeline {
  agent {
    dockerfile {
      filename 'Dockerfile'
    }

  }
  stages {
    stage('BUILD') {
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
            sh 'cd resources/js/my-todo-react'
            sh 'npm install'
            sh 'npm run build'
          }
        }

      }
    }

  }
}