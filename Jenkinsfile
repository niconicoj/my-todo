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
          }
        }

        stage('build APP') {
          steps {
            sh 'git submodule update --init'
          }
        }

      }
    }

  }
}