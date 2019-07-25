pipeline {
    environment {
        registry = "ulrich2002/roles-manager"
        registryCredential = 'dockerhub'
        dockerImage = ''
   }
    agent {
        docker {
            image 'ulrich2002/alpine-laravel-docker:0.0.8'
        }
    }
    options {
        skipStagesAfterUnstable()
    }
    stages {
        stage('Cloning Git') {
          steps {
            git 'https://github.com/ul2002/laravel-roles-management'
          }
        }
        stage('Build') {
           steps {
             sh 'cp env.prod .env && composer install '
           }
        }
        stage('Test') {
            steps {
                sh 'phpunit'
            }
        }
        stage('Building image') {
            steps {
                script {
                  dockerImage = docker.build registry + ":$BUILD_NUMBER"
                }
            }
        }
        stage('Deploy Image') {
          steps{
             script {
                docker.withRegistry( '', registryCredential ) {
                dockerImage.push()
              }
            }
          }
        }
        stage('Remove Unused docker image') {
          steps{
            sh "docker rmi $registry:$BUILD_NUMBER"
          }
        }
    	stage('Deploy Kubernetes Cluster') {
    	 steps {
    	  sshPublisher(
    	   continueOnError: false, failOnError: true,
    	   publishers: [
    	    sshPublisherDesc(
    	     configName: "kubernetes_server",
    	     verbose: true,
    	     transfers: [
    	      sshTransfer(
    	       sourceFiles: "",
    	       removePrefix: "",
    	       remoteDirectory: "laravel-roles-management",
    	       execCommand: "kubectl apply -f ."
    	      )
    	     ])
    	   ])
    	 }
    	}
    }
}