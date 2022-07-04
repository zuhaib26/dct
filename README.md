In oder to run this project you need to have PHP, Composer, Laravel installed.

To run the project use
```
php artisan serve
```

To create auth token for api use
1. go to your local host.
2. click register.
3. Enter details.
4. click register.
5. click on create new token.
6. enter name and click register.
7. copy and save the token.
8. you can use this token in api for authentication.
9. Apart from authorization add Accept and Content-Type in every api request with value application/json

By default user account of type customer will get created.
To make a user Customer Service executive can the user type to cse.


To create a new question 
make a post call to 
```
{{YOUR_LOCAL_HOST}}/api/question/
```
with body
```
{
    "question" : "Your Question?"
}
```
<h3>For Customer as well as Customer service executive</h3>

To check question
make a get call to 
```
{{YOUR_LOCAL_HOST}}/api/question/
```

To check details of a single question with full communication
make a get call to 
```
{{YOUR_LOCAL_HOST}}/api/question/{{QUESTION_ID}}
```
example
```
http://127.0.0.1:8000/api/question/1
```

To check Communication
make a get call to 
```
{{YOUR_LOCAL_HOST}}/api/communication/
```

To post a reply
make a post call to 
```
{{YOUR_LOCAL_HOST}}/api/communication/
```
with body
```
{
    "response": "This is the answer",
    "question_id": 1
}
```

If user wants to update question
make a put call to
```
{{YOUR_LOCAL_HOST}}/api/question/{{QUESTION_ID}}
```
example
```
http://127.0.0.1:8000/api/question/1
```
with body
```
{
    "question": "updated question"
}
```

<h3>Only For Customer service executive</h3>

To update status of question 
make a put call to
```
{{YOUR_LOCAL_HOST}}/api/question/{{QUESTION_ID}}
```
example
```
http://127.0.0.1:8000/api/question/1
```
with body
```
{
     "status": "Answered"
}
```
To Search using name
make a get call to
```
{{BASE_URL}}/api/search/name/{{name}}
```
example
```
http://127.0.0.1:8000/api/search/name/Zuhaib
```

To Search using status
make a get call to
```
{{BASE_URL}}/api/search/status/{{status}}
```
example
```
http://127.0.0.1:8000/api/search/status/Answered
```
