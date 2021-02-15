<?php
require_once('dbh.class.php');

class DbCreator extends Dbh
{
    /*   
        Class to (re)-generate database with a decent content. 

        This class is not used by the live web app.  
    */

    public function show_tables()
    {
        $sql = "SHOW TABLES";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        foreach ($results as $result) {
            print_r($result);
            echo "<br>";
        }
    }

    public function create_user_roles()
    {
        $sql = "CREATE TABLE user_roles(
                    role_id INT AUTO_INCREMENT PRIMARY KEY,
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
            user_id INT AUTO_INCREMENT PRIMARY KEY, 
            full_name VARCHAR(50) NOT NULL,
            password TEXT NOT NULL,
            email VARCHAR(30) NOT NULL UNIQUE,
            role_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            updated_by INT NULL,
            FOREIGN KEY (role_id) REFERENCES user_roles(role_id) ON DELETE SET NULL ON UPDATE CASCADE,
            FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
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
                    ('Kristian Møller Schmidt', '{$pwd}','krms@mail.com', 1),
                    ('Albert Einstein', '{$pwd}','ae@gmail.com', 1),
                    ('Isaac Newton','{$pwd}','in@gmail.com', 3),
                    ('Marie Curie', '{$pwd}','mc@gmail.com', 2),
                    ('Rocky Balboa', '{$pwd}','balboa@mail.com', 4),
                    ('Woody Allen', '{$pwd}','allen@mail.com', 2),
                    ('Steven Pinker','{$pwd}','steven@mail.com', 2),
                    ('Gerard Folland','{$pwd}','gerard@mail.com', 3),
                    ('Richard Dawkins','{$pwd}','richard@mail.com', 3),
                    ('Maxin Lapan','{$pwd}','maxin@mail.com',3),
                    ('Slavoj Zizek','{$pwd}','slavoj@mail.com',3),
                    ('Susan Pinker','{$pwd}','susan@mail.com', 3),
                    ('Rüdiger Safranski','{$pwd}','rödiger@mail.com', 3),
                    ('Peter Singer', '{$pwd}','psinger@mail.com', 2),
                    ('Nick Bostrom','{$pwd}','nbostrom@mail.com', 3),
                    ('Niels Bohr', '{$pwd}','nbohr@gmail.com', 4)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into users<br>";
    }

    public function create_projects()
    {
        $sql = "CREATE TABLE projects(
                    project_id INT AUTO_INCREMENT PRIMARY KEY, 
                    project_name TINYTEXT NOT NULL,
                    project_description TINYTEXT, 
                    created_by INT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created projects<br>";
    }

    public function insert_projects()
    {
        $sql = "INSERT INTO projects(project_name, project_description, created_by) VALUES
                ('Portfolio', 'An online portfolio to show some of my work', 1),
                ('Bug_Tracker PHP', 'A full featured bug tracking system made with PHP and MySQL', 1),
                ('Bug_Tracker Django', 'A Django version of my Bug_Tracker', 1),
                ('Fast Soduko Solver', 'A speed-uptimized sudoku solver using backtracking search and an arc-consistency algorithm.', 1),
                ('Puzzle solver', 'A web app that solves 8- and 15-puzzles backend and shows the solutions in the web page', 1),
                ('2048 AI-player', 'An AI-player for the classic 2048 game. AI uses mini-max search and different heuristics', 1),
                ('ML cancer diagnostics', 'A solution to the Kaggle cancer detection competition', 1)";
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
                    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE ON UPDATE CASCADE)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created project_enrollments<br>";
    }

    public function create_ticket_types()
    {
        $sql = "CREATE TABLE ticket_types(
                    ticket_type_id INT AUTO_INCREMENT PRIMARY KEY,
                    ticket_type_name TINYTEXT NOT NULL)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_types<br>";
    }

    public function insert_ticket_types()
    {
        $sql = "INSERT INTO ticket_types(ticket_type_name) 
                VALUES('Feature Request'),('Bug/Error'),('Other');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into ticket_types<br>";
    }

    public function create_ticket_status_types()
    {
        $sql =  "CREATE TABLE ticket_status_types(
                    ticket_status_id INT AUTO_INCREMENT PRIMARY KEY,
                    ticket_status_name TINYTEXT NOT NULL)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_status_types<br>";
    }

    public function insert_ticket_status_types()
    {
        $sql = "INSERT INTO ticket_status_types(ticket_status_name) 
                VALUES('Open'), ('Closed'), ('In Progress'), ('More Info Required');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into ticket_status_types<br>";
    }

    public function create_ticket_priorities()
    {
        $sql = "CREATE TABLE ticket_priorities(
                ticket_priority_id INT AUTO_INCREMENT PRIMARY KEY,
                ticket_priority_name TINYTEXT NOT NULL)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_priorities<br>";
    }

    public function insert_ticket_priorities()
    {
        $sql = "INSERT INTO ticket_priorities(ticket_priority_name) 
                VALUES('Low'),('Medium'),('High'),('Urgent');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into ticket_priorities<br>";
    }

    public function create_tickets()
    {
        $sql = "CREATE TABLE tickets(
            ticket_id INT AUTO_INCREMENT PRIMARY KEY,
            title TINYTEXT,
            project INT, /*can not be named project_id here as that's the name of the foreign key */
            developer_assigned INT, 
            priority INT,
            status INT,
            type INT,
            description TEXT,
            submitter INT, /* the person creating the ticket*/
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (project) REFERENCES projects(project_id) ON DELETE CASCADE ON UPDATE CASCADE, /* if project gets deleted, all tickets will as well */
            FOREIGN KEY (developer_assigned) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE, /*developer can't be deleted, if he is assigned to a ticcket */
            FOREIGN KEY (submitter) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
            FOREIGN KEY (priority) REFERENCES ticket_priorities(ticket_priority_id) ON DELETE SET NULL ON UPDATE CASCADE,
            FOREIGN KEY (status) REFERENCES ticket_status_types (ticket_status_id) ON DELETE SET NULL ON UPDATE CASCADE,
            FOREIGN KEY (type) REFERENCES ticket_types(ticket_type_id) ON DELETE SET NULL ON UPDATE CASCADE
        )";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created tickets<br>";
    }

    public function insert_tickets()
    {
        $sql = "INSERT INTO tickets
        (title, project, developer_assigned, priority, status, type, description, submitter) VALUES 
        ('Add links and documentation', 1, 3, 2, 3, 1, 'Add link to resume as PDF, add link to exam results and degrees',15),
        ('Clean up CSS',1,3,2,3,3,'Clean up CSS: Remove outdated classes',15), 
        ('Add info to empty data table representations', 2, 3,2,3,2,'Write No data available... ',20),
        ('Fix notifications button', 2,3, 2, 3,2,'Notications button not working. Fix this.',15 ), 
        ('Test database',2,7,2, 3,3,'Write code to test if relational database works as expected - including various constraints and update rules',15),
        ('Make alternative frontend designs',2,6,2,3,3, 'Make 3 design proposals for layout of website - consider Bootstrap',15),
        ('Make alternative frontend designs',2,6,2,3,2, 'Implement Show Next 10 Entries from database',15),
        ('Ticket dev constraints',2,5,4,3,1, 'Make sure that it is only possible to assign developers to a ticket, if the developer is assigned to the corresponding project',13),
        ('Demo acces to database',2,9,3,1,1,'Make sure that people logged in as demos do not mess up database. Two solutions possible: 1) regularly recreate database 2) Make a copy of database for each visitor',13),
        ('Fix notifications button',3,14,2,4,2,'Set up database stucture on Pythonanywhere',13),
        ('Add Running Time Info',4,14,1,2,1,'Make backend running time visible on website',13),
        ('Warn users about illegal input', 4,10,1,2,1,'Warn users when they input values other than digits 0-9',12),
        ('About info',5, 14,2, 2, 1, 'Add link to about page on the different algorithms', 13),
        ('Add unit testing of algorithsm', 5,11,2,2,1,'Add tests that confirm that search algorithms work exactly as expected',13),
        ('Python -> JS', 6,14,1,1,3,'Rewrite Python code base for the web app: Python->Javascript. The app would work better, if there was no Python backend, i.e. if the entire program just ran in the browser (JavaScript). At the moment, the entire website is downloaded for
        every move taken in the game, which is sub-optimal',13),  
        ('Improve heuristics',6,12,1,2,3,'Open-ended task: Try to improve performance of ai player by changing weights in monotonicity heuristic function.',13),
        ('Make first attempts',7,14,2, 1,3,'Play around with dataset and try different classification algorithms. Get an idea about the difficulties and opportunities. Write report.',13),
        ('Fix labels in dougnut chart',2,8,2,1,2,'Labels in doughtnut chart for most busy users is not showing properly. Fix this.',13)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into tickets<br>";
    }

    public function insert_project_enrollments()
    {   /* These values should correspond to the ones above, as users should be enrolled in the projects they have ticket in */
        $sql = "INSERT INTO project_enrollments (project_id, user_id) VALUES(1,3),(2,3),(2,7),(2,6),(2,5),(2,9),(3,14),(4,14),(4,10), (5,14),(5,11),(6,14),(6,12),(7,14),(2,8);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into project_enrollments<br>";
    }


    public function create_notification_types()
    {
        $sql = "CREATE TABLE notification_types(
                    notification_type_id INT AUTO_INCREMENT PRIMARY KEY,
                    notification_type tinytext
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created notification_types<br>";
    }

    public function insert_notification_types()
    {
        $sql = "INSERT INTO notification_types(notification_type) VALUES
                ('role updated'),
                ('assigned to ticket'),
                ('unassigned from ticket'),
                ('enrolled to project'),
                ('disenrolled from project'),
                ('account created');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Inserted values into notification_types<br>";
    }

    public function create_notifications()
    {
        $sql = "CREATE TABLE notifications(
                    notification_id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT,
                    notification_type INT,
                    message TEXT,
                    unseen BOOLEAN, /* 0 is false (notification not seen) 1 is true (seen) */
                    created_by INT, /* the person submitting the ticket*/
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (notification_type) REFERENCES notification_types (notification_type_id) ON DELETE SET NULL ON UPDATE CASCADE
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created notifications<br>";
    }

    public function create_sessions()
    {
        $sql = "CREATE TABLE sessions(
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            session_id_php VARCHAR(50),
            FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL ON UPDATE CASCADE
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
                    message text,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (commenter_user_id) REFERENCES users (user_id) ON DELETE SET NULL ON UPDATE CASCADE,
                    FOREIGN KEY (ticket_id) REFERENCES tickets (ticket_id) ON DELETE CASCADE ON UPDATE CASCADE
                )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        echo "Created ticket_comments<br>";
    }

    public function create_ticket_events()
    {
        $sql = "CREATE TABLE ticket_events(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    ticket_id INT,
                    event_type TEXT,  /* Perhaps I should make a table of event_types and turn this into a foreign key */
                    old_value TEXT,   /* This could be many things - an old comment, a user  etc - so I wont use foreign key here. */
                    new_value TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (ticket_id) REFERENCES tickets (ticket_id) ON DELETE CASCADE ON UPDATE CASCADE
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
        $this->insert_tickets();
        $this->insert_project_enrollments();
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
