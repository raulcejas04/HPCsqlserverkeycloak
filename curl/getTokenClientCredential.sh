curl --location --request POST 'http://localhost:8180/auth/realms/master/protocol/openid-connect/token' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'grant_type=client_credentials' \
--data-urlencode 'cliend_id=admin-cli' \
--data-urlencode 'client_secret=690fe5a6-a260-4d1f-ad6a-5966ae646b90'
