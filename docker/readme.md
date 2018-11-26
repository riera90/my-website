you must copy all Dockerfile, docker-compose.yaml and init.sh into the root or the project.  
For example, if you want to start the develop docker, you must, do as follows
        
        cp ./docker/dev/* ./
        docker-compose up --build
        
You might need to run ```docker-compose``` as root