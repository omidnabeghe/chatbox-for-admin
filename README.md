

CHATBOX FOR ADMINS TO SEE ALL CHATS AND ANSWER THEM

this was made by laravel, JQUERY , PHP , bootstrap , HTML , CSS

INSTRUCTION:

1-download project from GIT

2- after extract the file, you need to open project on vscode and write this on terminal: composer update

3-If github did not upload .env file. you need to add this file. you can change the name of .env.example to .env . i change it's DB_DATABASE=chatbox before. i also generate key (you can do this again by : php artisan key:generate).

4-this project need some tables in database. so first make a new table on your local database callled: chatbox then on your vscode terminal write this : php artisan migrate . now you have all tables in database. (i also attached database file callied: chatbox.sql so you can import it to your database.)

5- next you need 1 user to login with it. to make a new user, just write on terminal vscode : php artisan db:seed --class=StartTableSeeder . now you have a user and you can login with it to see http://localhost:8000/chat . email is : alfred@gmail.com and password is : 123 
if you need more user, just register and finally just write on vscode : php artisan serve 

6- now it is ready. just start chat as a user in blue button at the bottom right (you don't need to be login, just write your name and start chat)
7- if you logout chat (exit button), this chat will be over and if you start new chat with even the same name, new chat will be started and in admin panel will see 2 separete chat. so if any body want to see answer from admin, don't use exit button, 
8- as a admin , you need to login . this chat can have some admin , the only condition for it is user_type must be 1 . (if you register or use seeder, it automatically make a admin with user_type = 1).
9-if there was any new chat, blue button at the buttom right will show amount of all chats in red (notification). if you want to see who chat with you just press button : all chats to watch
on this page, you can see all chats with their name and red notification, you also can delete them. 

ATTENTION: this project is submitted for a sample and just for admin usage. so any user can not see each other chats or chat together. they only can chat with admin and see answer from admin.
