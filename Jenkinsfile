pipeline {
  agent any
  stages {
    stage('error') {
      steps {
        sh '''docker build -t $GIT_COMMIT .
docker run --network=default_network --network-alias=mytodo.niconico.io -e "VIRTUAL_HOST=mytodo.niconico.io" $GIT_COMMIT'''
      }
    }

  }
}