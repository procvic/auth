# Use cases

## 1. Get access token
For example call in terminal `curl -v "http://auth.procvic.cz/authenticate" -d "username=demouser&password=testpass"`.

Upper command return JSON with access_token. For example it can return `{"access_token":"14a5d0350728e976f53558725b0ea6ad4e8536b7","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"0f447f967b1e955d540730d7ed16979503ed8ccc"}`.


## 2. Check authorize user with access token
For example call in terminal `curl http://auth.procvic.cz/authorize?access_token=373a76b514b977d242851c25bd5f8e930267ec19`.

Upper command return JSON with information about state of authorize. For example it can return `{"is-authorize":true}`.
