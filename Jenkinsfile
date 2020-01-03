pipeline {
  agent {
    docker {
      image 'php:7.2-apache'
      args '''--network=default_network
--network-alias=mytodo.niconico.io
-e "VIRTUAL_HOST=mytodo.niconico.io"'''
    }

  }
  stages {
    stage('') {
      steps {
        input 'waiting'
      }
    }

  }
}