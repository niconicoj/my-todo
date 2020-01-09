pipeline {
  agent any
  stages {
    stage('error') {
      steps {
        sh '''docker build -t $GIT_COMMIT .
CONTAINER_ID=`docker run -d --network=default_network --network-alias=mytodo.niconico.io -e "VIRTUAL_HOST=mytodo.niconico.io" $GIT_COMMIT`
docker exec -it $CONTAINER_ID bash
pwd
exit'''
      }
    }

  }
}