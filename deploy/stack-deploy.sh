
#!/bin/bash
$(/home/jenkins/.local/bin/aws ecr get-login --no-include-email --region us-west-2)
docker stack deploy -c stack-deploy.yaml comp-ben-user  --with-registry-auth