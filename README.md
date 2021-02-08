# Bug Tracker Project - PHP, MYSQL

I've build this project from scratch - including relational database design, multi-role login system, backend and frontend.

During design and development, I tried to simulate the functionality of the bugtracking system
presented from the outside in this demo: https://www.youtube.com/watch?v=eWl8VtuXQFM&t=839s

Some features are still not implemented:

- Users should be able to change their name, email and password (easy fix)
- Naming conventions:

classes: MyClassName (camel case)
class files: myclassname.class.php
other files: lower_with_under
functions/methods: lower_with_under

Design-Patterns:
PRG Post-Redirect-Get: https://icodemag.com/prg-pattern-in-php-what-why-and-how/
Reflexive. Site is supported down to screen width 600ppx.
Database queries - PHP - and presentational code are held pretty separate. It is a strict MCV-patterns - this would be easier to implement in
webframework like Flask or Django or Laravel.
