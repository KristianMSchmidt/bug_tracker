# Bug Tracker Project - MYSQL, PHP, CSS, JAVASCRIPT, HTML

I've build this project from scratch - including relational database design, multi-role login system, backend and frontend.

My design of the website (overall functionality and user experience) has been inspired by this demo, showing another ticket tracking system from the outside: https://www.youtube.com/watch?v=eWl8VtuXQFM&t=839s

In my development, I've followed these design patterns and considerations:

1. Model-View-Control (MVC): A clear separation of database handling and queries (model), frontend and page layout (view) and the pure php scripts processing data in a layer between the model and the view (control).
2. Post-Redirect-Get (PRG): All post requests are processed and evaluated in separate .inc.php-files before being redirected back to the view-page. This prevents form data from being posted twice by accident and makes the back-button and page reloads function smoothly, greatly improving the user experince.
3. This frontend is size-responsive: The site probably works best on screens of a decent size, but the site is supported for all screens wider than a minimal width of 460. I've achieved most of this responsiveness using the CSS flexbox.
4. More security issues would no doubt have to be considered in a real world application, but I've done a bit: The sites only stores hashed passwords and user input is handled by prepared SQL-statements. Users from the outside have no acces to any of the content of the site, unless they are signed properly in (I've achieved this with login-checks and a .htacces-file hiding directory views and restricting acces to files in certaing directories). Registered users only have limited acces, depending on their role and particular project and ticket assignments.

Some features are still not implemented, e.g.,users should be able to change their name, email and password (easy fix).

I've only tested the website in Google Chrome. If something looks particularly ugly in Firefox or some other browser, try Chrome instead. If you encounter bugs on the site, please use the site to write a ticket describing the problem :-)
