-- DROP DATABASE IF EXISTS bug_tracker;
-- CREATE DATABASE IF NOT EXISTS bug_tracker;

CREATE TABLE bug_tracker.user_roles(
     id INT AUTO_INCREMENT PRIMARY KEY,
     role_name TINYTEXT NOT NULL
);

INSERT INTO bug_tracker.user_roles(role_name) 
    VALUES
        ('Admin'),
        ('Project Manager'),
        ('Developer'),
        ('Submitter');

CREATE TABLE bug_tracker.users(
    id INT AUTO_INCREMENT PRIMARY KEY, 
    full_name VARCHAR(255) NOT NULL,
    password TEXT NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    FOREIGN KEY (role_id) REFERENCES user_roles(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
);


INSERT INTO bug_tracker.users(full_name, password, email, role_id) 
    VALUES 
        ('Demo Admin', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','demoadmin@mail.com', 1),
        ('Demo PM','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','demopm@mail.com', 2),
        ('Demo Dev', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','demodev@mail.com', 3),
        ('Demo Sub', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','demosub@mail.com', 4),
        ('Kristian Schmidt', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','krms@mail.com', 1),
        ('Albert Einstein', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','ae@gmail.com', 3),
        ('Isaac Newton','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','in@gmail.com', 3),
        ('Marie Curie', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','mc@gmail.com', 3),
        ('Rocky Balboa', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','balboa@mail.com', 3),
        ('Woody Allen', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','allen@mail.com', 3),
        ('Steven Pinker','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','steven@mail.com', 3),
        ('Gerard Folland','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','gerard@mail.com', 3),
        ('Richard Dawkins','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','richard@mail.com', 3),
        ('Maxin Lapan','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','maxin@mail.com',3),
        ('Slavoj Zizek','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','slavoj@mail.com',3),
        ('Susan Pinker','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','susan@mail.com', 3),
        ('Rüdiger Safranski','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','rödiger@mail.com', 3),
        ('Peter Singer', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','psinger@mail.com',3),
        ('Nick Bostrom','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','nbostrom@mail.com', 2),
        ('Niels Bohr', '$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','nbohr@gmail.com', 4),
        ('Leonard Susskind','$2y$10$rdzTX0.TzJoS8B8GeX43xODVb8U5sAQB4fq81p7sfFmgsIRGvSI8u','susskind@gmail.com', 1);


CREATE TABLE bug_tracker.projects(
    id INT AUTO_INCREMENT PRIMARY KEY, 
    project_name VARCHAR(255) NOT NULL,
    project_description TINYTEXT, 
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
);

INSERT INTO bug_tracker.projects(project_name, project_description, created_by) VALUES
    ('Portfolio', 'An online portfolio showing some of my work', 5),
    ('Bug_Tracker PHP', 'A full-featured ticket tracking system made with PHP and MySQL',1),
    ('Bug_Tracker Django', 'A Django version of my BugTracker', 1),
    ('Fast Soduko Solver', 'A speed-uptimized sudoku solver using backtracking search and an arc-consistency algorithm.', 5),
    ('Puzzle solver', 'A web app that solves 8- and 15-puzzles backend and shows the solutions in the web page', 2),
    ('2048 AI-player', 'An AI-player for the classic 2048 game. AI uses mini-max search and different heuristics', 19),
    ('ML cancer diagnostics', 'A solution to the Kaggle cancer detection competition', 19);

CREATE TABLE bug_tracker.project_enrollments(
    user_id INT,
    project_id INT, 
    enrollment_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (user_id, project_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE bug_tracker.ticket_types(
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(255) NOT NULL
);

INSERT INTO bug_tracker.ticket_types(type_name) 
    VALUES('Feature Request'),('Bug/Error'),('Other');

CREATE TABLE bug_tracker.ticket_status_types(
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(255) NOT NULL
);

INSERT INTO bug_tracker.ticket_status_types(status_name) 
    VALUES('Open'), ('Closed'), ('In Progress'), ('More Info Required');

CREATE TABLE bug_tracker.ticket_priorities(
    id INT AUTO_INCREMENT PRIMARY KEY,
    priority_name VARCHAR(255) NOT NULL);


INSERT INTO bug_tracker.ticket_priorities(priority_name) 
    VALUES('Low'),('Medium'),('High'),('Urgent');

CREATE TABLE bug_tracker.tickets(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title TINYTEXT,
    project_id INT, /*can not be named project_id here as that's the name of the foreign key */
    developer_assigned_id INT, 
    priority_id INT,
    status_id INT,
    type_id INT,
    description TEXT,
    submitter_id INT, /* the user creating the ticket*/
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE ON UPDATE CASCADE, /* if project gets deleted, all tickets will as well */
    FOREIGN KEY (developer_assigned_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE, /*developer can't be deleted, if he is assigned to a ticcket */
    FOREIGN KEY (submitter_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (priority_id) REFERENCES ticket_priorities(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (status_id) REFERENCES ticket_status_types (id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (type_id) REFERENCES ticket_types(id) ON DELETE SET NULL ON UPDATE CASCADE
);

INSERT INTO bug_tracker.tickets
    (title, project_id, developer_assigned_id, priority_id, status_id, type_id, description, submitter_id) VALUES 
    ('Clean up deprecated CSS classes', 1, 7, 2, 3, 1, 'Check out SCSS warnings in VS-code and sort out the issues',19),
    ('Clean up CSS',1,3,2,3,3,'Clean up CSS: Remove outdated classes',4),
    ('Add info to empty tableas', 2, 3,2,3,2,'Write No data available... ',4),
    ('Fix notifications dropdown', 2,3, 2, 3,2,'Only a limited number of notifications should be shown by default. Fix this.',4 ), 
    ('Test database',2,3,2, 3,3,'Write code to test if relational database works as expected - including various constraints and update rules',4),
    ('Make alternative frontend designs',2,3,2,3,3, 'Make 3 design proposals for layout of website - consider Bootstrap',19),
    ('Limited table data',2,6,2,3,1, 'Implement Show Next 10 Entries from database. To make site scalable, user should not see all table data by default',20),
    ('Ticket dev constraints',2,10,4,3,1, 'Make sure that it is only possible to assign developers to a ticket, if the developer is assigned to the corresponding project',20),
    ('Demo acces to database',2,10,3,1,1,'Make sure that people logged in as demos do not mess up database. Two solutions possible: 1) regularly recreate database 2) Make a copy of database for each visitor',13),
    ('DB-structure',3,10,2,4,2,'Set up bugtracker database stucture on Pythonanywhere',15),
    ('Add Running Time Info',4,14,1,2,1,'Make backend running time visible on website',12),
    ('Warn users about illegal input', 4,11,1,2,1,'Warn users when they input values other than digits 0-9',3),
    ('About info',5, 9,2, 2, 1, 'Add link to about page on the different algorithms', 3),
    ('Add unit tests of algorithms', 5,3,2,2,1,'Add tests that confirm that search algorithms work exactly as expected',3),
    ('Python -> JS', 6,18,1,1,3,'Rewrite Python code base for the web app: Python->Javascript. The app would work better, if there was no Python backend, i.e. if the entire program just ran in the browser (JavaScript). At the moment, the entire website is downloaded for
    every move taken in the game, which is sub-optimal',13),  
    ('Improve heuristics',6,12,1,2,3,'Open-ended task: Try to improve performance of ai player by changing weights in monotonicity heuristic function.',13),
    ('Make first attempts',7,14,2, 1,3,'Play around with dataset and try different classification algorithms. Get an idea about the difficulties and opportunities. Write report.',13),
    ('Fix labels in dougnut chart',2,3,2,1,2,'Labels in doughtnut chart for most busy users is not showing properly. Fix this.',13),
    ('Table ordering options', 2, 3, 3, 1, 1,'Users should be able to change ordering of all tables on the site by clicking on the table headers', 4),
    ('Make tables searchable', 2, 1, 4, 2, 1, 'It should be possible to search table entries in all tables in the bugtracker app', 4);


INSERT INTO bug_tracker.project_enrollments (project_id, user_id) VALUES       
    /*demo admin=1*/ /*demo pm=2*/ /*demo dev=3*/ /*demo sub=4*/ /*schmidt admin=5*/ /*other devs 6-18*/ /*other sub 19*/                                                       /*sub 19*/
     /*portfolio*/ (1,1),(1,2),            (1,4),(1,6),(1,7),(1,19),
     /*bug php*/          (2,1),(2,3),(2,4),(2,6),(2,7),(2,8),(2,9),(2,10),(2,13), (2,19),(2,20),    
     /*bug django*/             (3,3),(3,4),(3,6),(3,7),(3,8),(3,10),(3,14),(3,15),
     /*sudoku r*/                (4,3),(4,4),(4,6),(4,7),(4,8),(4,10),(4,11),(4,12),(4,14),
     /*puzzle*/            (5,2),(5,3),(5,4),(5,6),(5,7),(5,9),(5,10),(5,11),(5,12),(5,14),
     /*2048*/                          (6,4),(6,6),(6,7),(6,12),(6,14),(6,16),(6,17),(6,18),
     /*ML cancer*/               (7,3),(7,4),(7,6),(7,7),(7,14),(7,15),(7,16),(7,17),(7,18);

CREATE TABLE bug_tracker.notification_types(
    id INT AUTO_INCREMENT PRIMARY KEY,
    submitter_action VARCHAR(255)
);

INSERT INTO bug_tracker.notification_types(submitter_action) VALUES
                ('updated your role to'),
                ('assigned you to the ticket'),
                ('unassigned you from the ticket'),
                ('enrolled you in the project'),
                ('disenrolled your from the project'),
                ('added a comment to your ticket');

CREATE TABLE bug_tracker.notifications(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    notification_type_id INT,
    info_id INT, /*id to new ticket, project, role or comment in question */
    unseen BOOLEAN, 
    created_by INT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (notification_type_id) REFERENCES notification_types (id) ON DELETE SET NULL ON UPDATE CASCADE
);

INSERT INTO bug_tracker.notifications (user_id, notification_type_id, info_id, unseen, created_by) VALUES
    /*Kristian Schmidt updated demo XX's role to demo XX*/
    (1, 1, 1, 1, 5),
    (2, 1, 2, 1, 5), 
    (3, 1, 3, 1, 5),
    (4, 1, 4, 1, 5),
    /*Leonard Susskind enrolled you in the project XX*/
    (1, 4, 1, 1, 21),
    (2, 4, 5, 1, 21), 
    (3, 4, 2, 1, 21),
    (4, 4, 2, 1, 21),
        /*Nick Botrom assigned you to the tickett XX*/
    (1, 2, 20, 1, 18), 
    (3, 2, 19, 1, 18);

CREATE TABLE bug_tracker.sessions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_id_php VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE bug_tracker.ticket_comments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    commenter_user_id INT,
    ticket_id INT,
    comment TEXT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (commenter_user_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE bug_tracker.ticket_event_types(
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_event_type VARCHAR(255) 
);

INSERT INTO bug_tracker.ticket_event_types(ticket_event_type) VALUES
    ('TitleChange'),
    ('DescriptionChange'),
    ('PriorityChange'),
    ('TypeChange'),
    ('StatusChange'),
    ('AssignedTo');

CREATE TABLE bug_tracker.ticket_events(
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT,
    type_id INT,  
    old_value VARCHAR(255),   
    new_value VARCHAR(255),   
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (type_id) REFERENCES ticket_event_types (id) ON DELETE CASCADE ON UPDATE CASCADE
);