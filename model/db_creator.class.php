<?php
require_once('dbh.class.php');

class DbCreator extends Dbh
{
    /*   
        Class to (re)-generate database with a decent content.
        
        Used for testing and development purposes only.

    */

    public function create_user_roles()
    {
        $sql = "CREATE TABLE user_roles(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    role_name TINYTEXT NOT NULL
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created user_roles<br>";
    }

    public function insert_user_roles()
    {
        $sql = "INSERT INTO user_roles(role_name) 
                VALUES
                    ('Admin'),
                    ('Project Manager'),
                    ('Developer'),
                    ('Submitter')";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into user_roles<br>";
    }

    public function create_users()
    {
        $sql = " CREATE TABLE users(
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
            )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created users<br>";
    }

    public function insert_users()
    {
        $pwd = password_hash('stjerne', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(full_name, password, email, role_id) 
                VALUES 
                    ('Demo Admin', '{$pwd}','demoadmin@mail.com', 1),
                    ('Demo PM','{$pwd}','demopm@mail.com', 2),
                    ('Demo Dev', '{$pwd}','demodev@mail.com', 3),
                    ('Demo Sub', '{$pwd}','demosub@mail.com', 4),
                    ('Kristian Schmidt', '{$pwd}','krms@mail.com', 1),
                    ('Albert Einstein', '{$pwd}','ae@gmail.com', 3),
                    ('Isaac Newton','{$pwd}','in@gmail.com', 3),
                    ('Marie Curie', '{$pwd}','mc@gmail.com', 3),
                    ('Rocky Balboa', '{$pwd}','balboa@mail.com', 3),
                    ('Woody Allen', '{$pwd}','allen@mail.com', 3),
                    ('Steven Pinker','{$pwd}','steven@mail.com', 3),
                    ('Gerard Folland','{$pwd}','gerard@mail.com', 3),
                    ('Richard Dawkins','{$pwd}','richard@mail.com', 3),
                    ('Maxin Lapan','{$pwd}','maxin@mail.com',3),
                    ('Slavoj Zizek','{$pwd}','slavoj@mail.com',3),
                    ('Susan Pinker','{$pwd}','susan@mail.com', 3),
                    ('Rüdiger Safranski','{$pwd}','rödiger@mail.com', 3),
                    ('Peter Singer', '{$pwd}','psinger@mail.com',3),
                    ('Nick Bostrom','{$pwd}','nbostrom@mail.com', 2),
                    ('Niels Bohr', '{$pwd}','nbohr@gmail.com', 4),
                    ('Leonard Susskind','{$pwd}','susskind@gmail.com', 1)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into users<br>";
    }

    public function create_projects()
    {
        $sql = "CREATE TABLE projects(
                    id INT AUTO_INCREMENT PRIMARY KEY, 
                    project_name VARCHAR(255) NOT NULL,
                    project_description TINYTEXT, 
                    created_by INT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created projects<br>";
    }

    public function insert_projects()
    {
        $sql = "INSERT INTO projects(project_name, project_description, created_by) VALUES
                ('Portfolio', 'An online portfolio showing some of my work', 5),
                ('Bug_Tracker PHP', 'A full-featured ticket tracking system made with PHP and MySQL',1),
                ('Bug_Tracker Django', 'A Django version of my BugTracker', 1),
                ('Fast Soduko Solver', 'A speed-uptimized sudoku solver using backtracking search and an arc-consistency algorithm.', 5),
                ('Puzzle solver', 'A web app that solves 8- and 15-puzzles backend and shows the solutions in the web page', 2),
                ('2048 AI-player', 'An AI-player for the classic 2048 game. AI uses mini-max search and different heuristics', 19),
                ('ML cancer diagnostics', 'A solution to the Kaggle cancer detection competition', 19)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into projects<br>";
    }

    public function create_project_enrollments()
    {
        $sql = "CREATE TABLE project_enrollments(
                    user_id INT,
                    project_id INT, 
                    enrollment_start DATE DEFAULT CURRENT_TIMESTAMP, 
                    PRIMARY KEY (user_id, project_id),
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE ON UPDATE CASCADE)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created project_enrollments<br>";
    }

    public function create_ticket_types()
    {
        $sql = "CREATE TABLE ticket_types(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    type_name VARCHAR(255) NOT NULL)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_types<br>";
    }

    public function insert_ticket_types()
    {
        $sql = "INSERT INTO ticket_types(type_name) 
                VALUES('Feature Request'),('Bug/Error'),('Other');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into ticket_types<br>";
    }

    public function create_ticket_status_types()
    {
        $sql =  "CREATE TABLE ticket_status_types(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    status_name VARCHAR(255) NOT NULL)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_status_types<br>";
    }

    public function insert_ticket_status_types()
    {
        $sql = "INSERT INTO ticket_status_types(status_name) 
                VALUES('Open'), ('Closed'), ('In Progress'), ('More Info Required');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into ticket_status_types<br>";
    }

    public function create_ticket_priorities()
    {
        $sql = "CREATE TABLE ticket_priorities(
                id INT AUTO_INCREMENT PRIMARY KEY,
                priority_name VARCHAR(255) NOT NULL)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_priorities<br>";
    }

    public function insert_ticket_priorities()
    {
        $sql = "INSERT INTO ticket_priorities(priority_name) 
                VALUES('Low'),('Medium'),('High'),('Urgent');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into ticket_priorities<br>";
    }

    public function create_tickets()
    {
        $sql = "CREATE TABLE tickets(
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
        )";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created tickets<br>";
    }

    public function insert_tickets()
    {
        $sql = "INSERT INTO tickets
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
        ('Table ordering options', 2, 3, 3, 1, 1,'Users should be able to altern orderings of all tables on the site by clicking on the table headers', 4),
        ('Make tables searchable', 2, 1, 4, 2, 1, 'It should be possible to search table entries in all tables in the bugtracker app', 4);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into tickets<br>";
    }

    public function insert_project_enrollments()
    {   /* These values should correspond to the ones above, as users should be enrolled in the projects they are assigned to as devs or submitters */
        $sql = "INSERT INTO project_enrollments (project_id, user_id) VALUES
       
                    /*demo admin=1*/ /*demo pm=2*/ /*demo dev=3*/ /*demo sub=4*/ /*schmidt admin=5*/ /*other devs 6-18*/ /*other sub 19*/                                                       /*sub 19*/
       /*portfolio*/ (1,2),            (1,4),(1,6),(1,7),(1,19),
      /*bug php*/          (2,1),(2,3),(2,4),(2,6),(2,7),(2,8),(2,9),(2,10),(2,13), (2,19),(2,20),    
      /*bug django*/             (3,3),(3,4),(3,6),(3,7),(3,8),(3,10),(3,14),(3,15),
     /*sudoku r*/                (4,3),(4,4),(4,6),(4,7),(4,8),(4,10),(4,11),(4,12),(4,14),
     /*puzzle*/            (5,2),(5,3),(5,4),(5,6),(5,7),(5,9),(5,10),(5,11),(5,12),(5,14),
     /*2048*/                          (6,4),(6,6),(6,7),(6,12),(6,14),(6,16),(6,17),(6,18),
     /*ML cancer*/               (7,3),(7,4),(7,6),(7,7),(7,14),(7,15),(7,16),(7,17),(7,18)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into project_enrollments<br>";
    }

    public function create_notification_types()
    {
        $sql = "CREATE TABLE notification_types(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    submitter_action VARCHAR(255)
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created notification_types<br>";
    }

    public function insert_notification_types()
    {
        $sql = "INSERT INTO notification_types(submitter_action) VALUES
                ('updated your role to'),
                ('assigned you to the ticket'),
                ('unassigned you from the ticket'),
                ('enrolled you in the project'),
                ('disenrolled your from the project'),
                ('added a comment to your ticket')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into notification_types<br>";
    }

    public function create_notifications()
    {
        $sql = "CREATE TABLE notifications(
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
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created notifications<br>";
    }

    public function insert_notifications()
    {
        $sql = "INSERT INTO notifications (user_id, notification_type_id, info_id, unseen, created_by) VALUES
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
                (3, 2, 19, 1, 18)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into notifications<br>";
    }

    public function create_sessions()
    {
        $sql = "CREATE TABLE sessions(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    session_id_php VARCHAR(255),
                    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE
                 )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created sessions<br>";
    }

    public function create_ticket_comments()
    {
        $sql = "CREATE TABLE ticket_comments(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    commenter_user_id INT,
                    ticket_id INT,
                    comment TEXT, 
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (commenter_user_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE,
                    FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON DELETE CASCADE ON UPDATE CASCADE
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_comments<br>";
    }

    public function create_ticket_event_types()
    {
        $sql = "CREATE TABLE ticket_event_types(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    ticket_event_type VARCHAR(255) 
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_events<br>";
    }

    public function insert_ticket_event_types()
    {
        $sql = "INSERT INTO ticket_event_types(ticket_event_type) VALUES
                ('TitleChange'),
                ('DescriptionChange'),
                ('PriorityChange'),
                ('TypeChange'),
                ('StatusChange'),
                ('AssignedTo');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into ticket_event_types<br>";
    }

    public function create_ticket_events()
    {
        $sql = "CREATE TABLE ticket_events(
                id INT AUTO_INCREMENT PRIMARY KEY,
                ticket_id INT,
                type_id INT,  
                old_value VARCHAR(255),   
                new_value VARCHAR(255),   
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (type_id) REFERENCES ticket_event_types (id) ON DELETE CASCADE ON UPDATE CASCADE
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_events<br>";
    }

    public function drop_all_tables()
    {
        echo "DROPPING TABLES:<br>";

        $sql = "SET FOREIGN_KEY_CHECKS = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $tables = [
            'ticket_events',
            'ticket_event_types',
            'notifications',
            'notification_types',
            'ticket_comments',
            'tickets',
            'ticket_priorities',
            'ticket_status_types',
            'ticket_types',
            'project_enrollments',
            'projects',
            'sessions',
            'users',
            'user_roles',
        ];

        foreach ($tables as $table) {
            $sql = "DROP TABLE IF EXISTS {$table}";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            echo "Dropped table {$table}<br>";
        }
        echo "Dropped all tables<br>";
    }

    public function create_all_tables()
    {
        echo "<br>CREATING TABLES:<br>";
        $this->create_user_roles();
        $this->create_users();
        $this->create_projects();
        $this->create_project_enrollments();
        $this->create_ticket_types();
        $this->create_ticket_status_types();
        $this->create_ticket_priorities();
        $this->create_tickets();
        $this->create_notification_types();
        $this->create_notifications();
        $this->create_ticket_comments();
        $this->create_ticket_event_types();
        $this->create_ticket_events();
        $this->create_sessions();
    }

    public function insert_all_values()
    {
        echo "<br>INSERTING VALUES INTO TABLES:<br>";
        $this->insert_user_roles();
        $this->insert_notification_types();
        $this->insert_ticket_priorities();
        $this->insert_ticket_status_types();
        $this->insert_ticket_types();
        $this->insert_users();
        $this->insert_projects();
        $this->insert_ticket_event_types();
        $this->insert_tickets();
        $this->insert_project_enrollments();
        $this->insert_notifications();
    }

    public function drop_create_insert_all()
    {
        $this->drop_all_tables();
        $this->create_all_tables();
        $this->insert_all_values();
    }
}

$dbc = new DbCreator();
$dbc->drop_create_insert_all();
