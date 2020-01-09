pipeline {
  agent any
  stages {
    stage('error') {
      steps {
        sh '''docker build $GIT_COMMIT .
docker run $GIT_COMMIT --network=default_network --network-alias=mytodo.niconico.io -e "VIRTUAL_HOST=mytodo.niconico.io'''
      }
    }

  }
}