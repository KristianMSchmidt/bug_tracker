SHOW DATABASES;
DROP DATABASE IF EXISTS test;
CREATE DATABASE test;   
USE test;

DROP TABLE IF EXISTS user_roles;
CREATE TABLE user_roles(
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name TINYTEXT NOT NULL
);
DESCRIBE user_roles;

INSERT INTO user_roles(role_name) VALUES('Admin');
INSERT INTO user_roles(role_name) VALUES('Project Manager');
INSERT INTO user_roles(role_name) VALUES('Developer');
INSERT INTO user_roles(role_name) VALUES('Submitter');

SELECT * from user_roles;
DROP TABLE IF EXISTS users;
CREATE TABLE users(
    user_id INT AUTO_INCREMENT PRIMARY KEY, 
    full_name VARCHAR(50) NOT NULL,
    password TEXT NOT NULL,
    email VARCHAR(30) NOT NULL UNIQUE,
    role_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT,
    FOREIGN KEY (role_id) REFERENCES user_roles(role_id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
);
DESCRIBE users;

/* For simplicity, I've given all predefined users the same password: 'stjerne'. This is stored in the database in 
   a hashed version generated by the php command: password_hash('stjerne', PASSWORD_DEFAULT); */

INSERT INTO users(full_name, password, email, role_id) VALUES('Kristian Schmidt', '$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','kimarokko@hotmail.com', 1);
INSERT INTO users(full_name, password, email, role_id) VALUES('Albert Einstein', '$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','ae@gmail.com', 1);
INSERT INTO users(full_name, password, email, role_id) VALUES('Isaac Newton','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','in@gmail.com', 3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Marie Curie', '$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','mc@gmail.com', 2);
INSERT INTO users(full_name, password, email, role_id) VALUES('Rocky Balboa', '$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','balboa@gmail.com', 4);
INSERT INTO users(full_name, password, email, role_id) VALUES('Woody Allen', '$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','allen@mail.com', 2);
INSERT INTO users(full_name, password, email, role_id) VALUES('Steven Pinker','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','steven@mail.com', 2);
INSERT INTO users(full_name, password, email, role_id) VALUES('Gerard Folland','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','gerard@mail.com', 3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Richard Dawkins','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','richard@mail.com', 3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Maxin Lapan','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','maxin@mail.com',3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Slavoj Zizek','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','slavoj@mail.com',3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Susan Pinker','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','susan@mail.com', 3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Rüdiger Safranski','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','rödiger@mail.com', 3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Peter Singer', '$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','psinger@mail.com', 2);
INSERT INTO users(full_name, password, email, role_id) VALUES('Nick Bostrom','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','nbostrom@mail.com', 3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Niels Bohr', '$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','nbohr@gmail.com', 4);


INSERT INTO users(full_name, password, email, role_id) VALUES('Demo Admin','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','demoadmin@gmail.com', 1);
INSERT INTO users(full_name, password, email, role_id) VALUES('Demo PM','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','demopm@gmail.com', 2);
INSERT INTO users(full_name, password, email, role_id) VALUES('Demo Dev','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','demodev@gmail.com', 3);
INSERT INTO users(full_name, password, email, role_id) VALUES('Demo Sub','$2y$10$aaHfd.sfetH.JY6JMFkQveIF0UjKl85tBZBE7VGkfWI3vBIXZjPFK','demosub@gmail.com', 4);

SELECT * FROM users;

DROP TABLE IF EXISTS projects;
CREATE TABLE projects(
    project_id INT AUTO_INCREMENT PRIMARY KEY, 
    project_name TINYTEXT NOT NULL,
    project_description TINYTEXT, 
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
    );
DESCRIBE projects;

INSERT INTO projects(project_name, project_description, created_by) 
VALUES('Portfolio', 'An online portfolio to show some of my work', 1);

INSERT INTO projects(project_name, project_description, created_by) 
VALUES('Bug_Tracker PHP', 'A full features bug tracking system made with PHP and MySQL', 1);

INSERT INTO projects(project_name, project_description, created_by) 
VALUES('Bug_Tracker Python', 'A full features bug tracking system made with Python, Flask and MySQL', 1);

INSERT INTO projects(project_name, project_description, created_by) 
VALUES('Fast Soduko Solver', 'A speed-uptimized sudoku solver using backtracking search and an arc-consistency algorithm.', 1);

INSERT INTO projects(project_name, project_description, created_by) 
VALUES('Puzzle solver', 'A web app that solves 8- and 15-puzzles backend and shows the solutions in the web page', 1);

INSERT INTO projects(project_name, project_description, created_by) 
VALUES('2048 AI-player', 'An AI-player for the classic 2048 game. AI uses mini-max search and different heuristics', 1);

INSERT INTO projects(project_name, project_description, created_by) 
VALUES('ML cancer diagnostics', 'A solution to the Kaggle cancer detection competition', 1);

SELECT * FROM projects;

DROP TABLE IF EXISTS project_enrollments;
CREATE TABLE project_enrollments(
    user_id INT,
    project_id INT, 
    enrollment_start DATE DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (user_id, project_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE ON UPDATE CASCADE
);
DESCRIBE project_enrollments;

/*Kristian_ADMIN is in every project */
INSERT INTO project_enrollments(user_id, project_id) VALUES(1, 1);
INSERT INTO project_enrollments(user_id, project_id) VALUES(1, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(1, 3);
INSERT INTO project_enrollments(user_id, project_id) VALUES(1, 4);
INSERT INTO project_enrollments(user_id, project_id) VALUES(1, 5);
INSERT INTO project_enrollments(user_id, project_id) VALUES(1, 6);
INSERT INTO project_enrollments(user_id, project_id) VALUES(1, 7);

/*Kristian_PM is in every project */
INSERT INTO project_enrollments(user_id, project_id) VALUES(13, 1);
INSERT INTO project_enrollments(user_id, project_id) VALUES(13, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(13, 3);
INSERT INTO project_enrollments(user_id, project_id) VALUES(13, 4);
INSERT INTO project_enrollments(user_id, project_id) VALUES(13, 5);
INSERT INTO project_enrollments(user_id, project_id) VALUES(13, 6);
INSERT INTO project_enrollments(user_id, project_id) VALUES(13, 7);

/*Kristian_DEV is in every project */
INSERT INTO project_enrollments(user_id, project_id) VALUES(14, 1);
INSERT INTO project_enrollments(user_id, project_id) VALUES(14, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(14, 3);
INSERT INTO project_enrollments(user_id, project_id) VALUES(14, 4);
INSERT INTO project_enrollments(user_id, project_id) VALUES(14, 5);
INSERT INTO project_enrollments(user_id, project_id) VALUES(14, 6);
INSERT INTO project_enrollments(user_id, project_id) VALUES(14, 7);

/*Other project enrollments */
INSERT INTO project_enrollments(user_id, project_id) VALUES(2, 1);
INSERT INTO project_enrollments(user_id, project_id) VALUES(2, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(3, 3);
INSERT INTO project_enrollments(user_id, project_id) VALUES(3, 4);
INSERT INTO project_enrollments(user_id, project_id) VALUES(4, 5);
INSERT INTO project_enrollments(user_id, project_id) VALUES(4, 6);
INSERT INTO project_enrollments(user_id, project_id) VALUES(5, 7);
INSERT INTO project_enrollments(user_id, project_id) VALUES(5, 1);
INSERT INTO project_enrollments(user_id, project_id) VALUES(6, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(6, 3);
INSERT INTO project_enrollments(user_id, project_id) VALUES(7, 4);
INSERT INTO project_enrollments(user_id, project_id) VALUES(7, 5);
INSERT INTO project_enrollments(user_id, project_id) VALUES(8, 6);
INSERT INTO project_enrollments(user_id, project_id) VALUES(8, 7);
INSERT INTO project_enrollments(user_id, project_id) VALUES(9, 1);
INSERT INTO project_enrollments(user_id, project_id) VALUES(9, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(10, 3);
INSERT INTO project_enrollments(user_id, project_id) VALUES(10, 4);
INSERT INTO project_enrollments(user_id, project_id) VALUES(11, 5);
INSERT INTO project_enrollments(user_id, project_id) VALUES(11, 6);
INSERT INTO project_enrollments(user_id, project_id) VALUES(12, 7);
INSERT INTO project_enrollments(user_id, project_id) VALUES(12, 1);

INSERT INTO project_enrollments(user_id, project_id) VALUES(8, 1);
INSERT INTO project_enrollments(user_id, project_id) VALUES(7, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(6, 5);
INSERT INTO project_enrollments(user_id, project_id) VALUES(5, 2);
INSERT INTO project_enrollments(user_id, project_id) VALUES(12, 6);

INSERT INTO project_enrollments(user_id, project_id) VALUES(15, 6);
INSERT INTO project_enrollments(user_id, project_id) VALUES(15, 5);

SELECT * FROM project_enrollments;

DROP TABLE IF EXISTS ticket_types;
CREATE TABLE ticket_types(
    ticket_type_id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_type_name TINYTEXT NOT NULL
);
INSERT INTO ticket_types(ticket_type_name) VALUES('Feature Request');
INSERT INTO ticket_types(ticket_type_name) VALUES('Bug/Error');
INSERT INTO ticket_types(ticket_type_name) VALUES('Other');
    
DESCRIBE ticket_types;
SELECT * FROM ticket_types;

DROP TABLE IF EXISTS ticket_status_types;
CREATE TABLE ticket_status_types(
    ticket_status_id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_status_name TINYTEXT NOT NULL
);
INSERT INTO ticket_status_types(ticket_status_name) VALUES('Open');
INSERT INTO ticket_status_types(ticket_status_name) VALUES('Closed');
INSERT INTO ticket_status_types(ticket_status_name) VALUES('In Progress');
INSERT INTO ticket_status_types(ticket_status_name) VALUES('More Info Required');
DESCRIBE ticket_status_types;
SELECT * FROM ticket_status_types;

DROP TABLE IF EXISTS ticket_priorities;
CREATE TABLE ticket_priorities(
    ticket_priority_id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_priority_name TINYTEXT NOT NULL
);
INSERT INTO ticket_priorities(ticket_priority_name) VALUES('Low');
INSERT INTO ticket_priorities(ticket_priority_name) VALUES('Medium');
INSERT INTO ticket_priorities(ticket_priority_name) VALUES('High');
INSERT INTO ticket_priorities(ticket_priority_name) VALUES('Urgent');
DESCRIBE ticket_priorities;
SELECT * FROM ticket_priorities;


DROP TABLE IF EXISTS tickets;
CREATE TABLE tickets(
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    title TINYTEXT NOT NULL,
    project INT, /*can not be named project_id here as that's the name of the foreign key */
    developer_assigned INT, 
    priority INT,
    status INT,
    type INT,
    description TEXT,
    submitter INT, /* the person submitting the ticket*/
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project) REFERENCES projects(project_id) ON DELETE CASCADE ON UPDATE CASCADE, /* if project gets deleted, all tickets will as well */
    FOREIGN KEY (developer_assigned) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE, /*developer can't be deleted, if he is assigned to a ticcket */
    FOREIGN KEY (submitter) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (priority) REFERENCES ticket_priorities(ticket_priority_id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (status) REFERENCES ticket_status_types (ticket_status_id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (type) REFERENCES ticket_types(ticket_type_id) ON DELETE RESTRICT ON UPDATE CASCADE
);
DESCRIBE tickets;

/* LAV REELLE TICKETS SOM FAKTISK BETYDER NOGET FOR MIG */
/* Bemærk: Man skal være tilknyttet projektet for at kunne få en ticket i projektet -- kan denne
begrænsning kodes in i the foreign key ?*/

INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Add links and documentation', /*title*/ 
        1, /* Project 1 is Portfolio */ 
        3, /* dev assigned: Kristian_dev */ 
        2, /*medium*/ 
        3, /*ticket status: in progress*/
        1, /* ticket type: Feature Requst*/
        'Add link to resume as PDF, add link to exam results and degrees',
        15 /*submitter: demo submitter */  
); 

INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Clean up CSS', /*title*/ 
        1, /* Project 1 is Portfolio */ 
        3, /* dev assigned: Kristian_dev */ 
        2, /*medium*/ 
        3, /*ticket status: in progress*/
        3, /* ticket type: Other*/
        'Clean up CSS: Remove outdated classes',
        15 /*submitter: demo submitter */  
); 

INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Add info to empty data table representations', /*title*/ 
        2, /* Project 1 is Portfolio */ 
        19, /* dev assigned: Kristian_dev */ 
        2, /*medium*/ 
        3, /*ticket status: in progress*/
        2, /* ticket type: Other*/
        'Write No data available... ',
        20 
); 
INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Fix notifications button', /*title*/ 
        2, /* Project 2 is Bugtracker PHP */ 
        3, /* dev assigned: Kristian_dev */ 
        2, /*medium*/ 
        3, /*ticket status: in progress*/
        2, /* ticket type: Bug*/
        'Notications button not working. Fix this.',
        15 /*submitter: demo submitter */  
); 

INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Test database', /*title*/ 
        2, /* Project 2 is Bugtracker PHP */ 
        7, /* dev assigned: */ 
        2, /*medium*/ 
        3, /*ticket status: open*/
        3, /* ticket type: other */
        'Write code to test if relational database works as expected - including various constraints and update rules',
        15 /*submitter: demo submitter */  
); 


INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Make alternative frontend designs', /*title*/ 
        2, /* Project 2 is Bugtracker PHP */ 
        6, /* dev assigned: */ 
        2, /*medium*/ 
        3, /*ticket status: open*/
        3, /* ticket type: other */
        'Make 3 design proposals for layout of website - consider Bootstrap',
        15 /*submitter: demo submitter */  
); 
INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Make alternative frontend designs', /*title*/ 
        2, /* Project 2 is Bugtracker PHP */ 
        6, /* dev assigned: */ 
        2, /*medium*/ 
        3, /*ticket status: open*/
        2, /* ticket type: other */
        'Implement "show next 10 entries" from database',
        15 /*submitter: demo submitter */  
); 


INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Ticket dev constraints', /*title*/ 
        2, /* Project 2 is Bugtracker PHP */ 
        5, /* dev assigned: */ 
        4, /*urgent*/ 
        3, /*ticket status: open*/
        1, /* ticket type: feature req */
        'Make sure that it is only possible to assign developers to a ticket, if the developer is assigned to the corresponding project',
        13 /*submitter: Kristian_pm */  
); 

INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Demo acces to database', /*title*/ 
        2, /* Project 2 is Bugtracker PHP */ 
        9, /* dev assigned: Kristian_dev */ 
        3, /*high*/ 
        1, /*ticket status: open*/
        1, /* ticket type: Feature*/
        'Make sure that people logged in as demos do not mess up database. Two solutions possible: 1) regularly recreate database 2) Make a copy of database for each visitor',
        13 /*submitter: Kristian_pm */  
); 

INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Fix notifications button', /*title*/ 
        3, /* Project 3 is Bugtracker Python */ 
        14, /* dev assigned: Kristian_dev */ 
        2, /*low*/ 
        4, /*ticket status: more info required*/
        2, /* ticket type: bugs/errors*/
        'Set up database stucture on Pythonanywhere',
        13 /*submitter: Kristian_pm */  
); 


INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Add Running Time Info', /*title*/ 
        4, /*project 4 is Sudoku*/ 
        14, /* dev assined: Kristian_dev */ 
        1, /*medium*/ 
        2, /*ticket status: closed*/
        1, /* ticket type: feature request*/
        'Make backend running time visible on website',
        13 /*submitter: Kristian_pm */  
); 



INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Warn users about illegal input', /*title*/ 
        4, /*project 4 is Sudoku*/ 
        10, /* dev assined: */ 
        1, /*medium*/ 
        2, /*ticket status: closed*/
        1, /* ticket type: feature request*/
        'Warn users when they input values other than digits 0-9',
        12 /*submitter: Kristian_admin */  
); 


INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('About info', /*title*/ 
        5, /*project 5 is 15-Puzzle*/ 
        14, /* dev assined: Kristian_dev */ 
        2, /*medium*/ 
        2, /*ticket status: closed*/
        1, /* ticket type: feature request*/
        'Add link to about page on the different algorithms',
        13 /*submitter: Kristian_pm */  
); 


INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Add unit testing of algorithsm', /*title*/ 
        5, /*project 5 is 15-Puzzle*/ 
        11, /* dev assined:*/ 
        2, /*medium*/ 
        2, /*ticket status: closed*/
        1, /* ticket type: feature request*/
        'Add tests that confirm that search algorithms work exactly as expected',
        13 /*submitter: Kristian_pm */  
); 



INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Python -> JS', 
       6, /*project: 2048*/ 
       14, /* dev assined: Kristian_dev */ 
       1, /*low*/ 
       1, /*ticket status: open*/
       3, /* ticket type: Other*/
        'Rewrite Python code base for the web app: Python->Javascript. The app would work better, if there was no Python backend, i.e. if
        the entire program just ran in the browser (JavaScript). At the moment, the entire website is downloaded for
        every move taken in the game, which is sub-optimal',
        13 /*submitter: Kristian_pm */  
        ); 

INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Improve heuristics', 
       6, /*project: 2048*/ 
       12, /* dev assined: */ 
       1, /*low*/ 
       2, /*ticket status: closed*/
       3, /* ticket type: Other*/
        'Open-ended task: Try to improve performance of ai player by changing weights in monotonicity heuristic function.',
        13 /*submitter: Kristian_pm */  
        ); 


INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Make first attempts', /*title*/ 
        7, /*project 7 is ML cancer detection*/ 
        14, /* dev assined: Kristian_dev */ 
        2, /*medium*/ 
        1, /*ticket status: open*/
        3, /* ticket type: other*/
        'Play around with dataset and try different classification algorithms. Get an idea about the
        difficulties and opportunities. Write report.',
        13 /*submitter: Kristian_pm */  
); 


INSERT INTO tickets(title, project, developer_assigned, priority, status, type, description, submitter) 
VALUES('Fix labels in dougnut chart', /*title*/ 
        2, /*project 7 is ML cancer detection*/ 
        8, /* dev assined: Kristian_dev */ 
        2, /*medium*/ 
        1, /*ticket status: open*/
        2, /* ticket type: bug/error*/
        'Labels in doughtnut chart for most busy users is not showing properly. Fix this.',
        13 /*submitter: Kristian_pm */  
); 
SELECT * FROM tickets;

DROP TABLE IF EXISTS notification_types;
CREATE TABLE notification_types(
    notification_type_id INT AUTO_INCREMENT PRIMARY KEY,
    notification_type tinytext
);

INSERT INTO notification_types(notification_type) VALUES('role updated'); 
INSERT INTO notification_types(notification_type) VALUES('assigned to ticket'); 
INSERT INTO notification_types(notification_type) VALUES('unassigned from ticket'); 
INSERT INTO notification_types(notification_type) VALUES('enrolled to project'); 
INSERT INTO notification_types(notification_type) VALUES('disenrolled from project'); 
INSERT INTO notification_types(notification_type) VALUES('account created'); 



DROP TABLE IF EXISTS notifications;
CREATE TABLE notifications(
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    notification_type INT,
    message TEXT,
    unseen BOOLEAN, /* 0 is false (notification not seen) 1 is true (seen) */
    created_by INT, /* the person submitting the ticket*/
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (notification_type) REFERENCES notification_types (notification_type_id) ON DELETE RESTRICT ON UPDATE CASCADE
);

/* role update */
INSERT INTO notifications(user_id, notification_type, message, unseen, created_by) VALUES(17, 1, "updated your role to 'Admin'", true, 1); 
INSERT INTO notifications(user_id, notification_type,message,  unseen, created_by) VALUES(17, 2, "assigned you to the ticket 'Hell is loose'", true, 2); 
INSERT INTO notifications(user_id, notification_type,message,  unseen, created_by) VALUES(17, 3,  "unassigned you from the ticket 'Gammel billet'",true, 3); 
INSERT INTO notifications(user_id, notification_type,message,  unseen, created_by) VALUES(17, 4, "enrolled you to the project 'Nyt project'", true, 4); 

select * from notifications;

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_id_php VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL ON UPDATE CASCADE
);

describe sessions;


DROP TABLE IF EXISTS ticket_comments;
CREATE TABLE ticket_comments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    commenter_user_id INT,
    ticket_id INT,
    message text,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (commenter_user_id) REFERENCES users (user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (ticket_id) REFERENCES tickets (ticket_id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO ticket_comments(commenter_user_id, ticket_id, message) VALUES(5, 1, "Get this done! Asap!"); 
INSERT INTO ticket_comments(commenter_user_id, ticket_id, message) VALUES(1, 1, "Comment #2"); 

select * from tickets

DROP TABLE IF EXISTS ticket_history;
CREATE TABLE ticket_history(
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT,
    event_type TEXT,  /* I could make a table of eventy_types and turn this into a foreign key */
    old_value TEXT,   /* this has to represent many things... so I wont use foreign keys. */
    new_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets (ticket_id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO ticket_history(ticket_id, event_type, old_value, new_value)
VALUES(1, "AssignedTo", "Steven Pinker", "Richard Dawkins"); 


INSERT INTO ticket_history(ticket_id, event_type, old_value, new_value)
VALUES(1, "StatusChange", "In Progress", "Closed"); 

select * from ticket_history;