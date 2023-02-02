DROP DATABASE dinosrent;

CREATE DATABASE IF NOT EXISTS dinosrent CHARACTER SET utf8;



-- Ο πινακας months έχει αποθηκευμένα τα ονόματα των μηνών έτσι ώστε όταν σε μία κράτηση συμπίπτουν παραπάνω από ένας μηνας, να μπορουμε να παίρνουμε το όνομα του επόμενου δηλαδή +1
-- CREATE TABLE dinosrent.months (
-- 	no_of		INT(6)			NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
--     name_of		VARCHAR(12)		NOT NULL
-- );
-- INSERT INTO dinosrent.months (no_of, name_of) VALUES ('1', 'cars112021');
-- INSERT INTO dinosrent.months (name_of) VALUES ('cars122021');


CREATE TABLE price (	  
    id_category		int(2) PRIMARY KEY,
	amount     		DOUBLE(5, 2)
);

INSERT INTO price (id_category, amount) VALUES ('1', '50.00');
INSERT INTO price (id_category, amount) VALUES ('2', '40.00');

-- Ο πινακας cars περιέχει πληροφορίες για τα αυτοκίνηταcars

CREATE TABLE cars (
	car_id		INT(4)			NOT NULL  PRIMARY KEY AUTO_INCREMENT,
    type_of		INT(2)          NOT NULL,
    brand       VARCHAR(50)     NOT NULL,
    model       VARCHAR(50)     NOT NULL,
    pers		INT(2)          NOT NULL,
    doors		INT(2)          NOT NULL,
    trans       VARCHAR(50)     NOT NULL,
    img_path	VARCHAR(50)		NOT NULL,
    descr       VARCHAR(1000)	NOT NULL,
    FOREIGN KEY (type_of) REFERENCES price(id_category) ON DELETE RESTRICT
    
);

INSERT INTO cars (car_id, type_of, brand, model, pers, doors, trans,img_path, descr) VALUES ('1', '2', 'Citroen', 'C1', '4','3','auto', 'images/c1.jpg', 'Το νέο CITROEN C1 είναι διαθέσιμο στις νέες ειδικές εκδόσεις ELLE και URBAN RIDE, που έχουν ως στόχο να ταιριάξουν με τον νεανικό τρόπο ζωής, καλύπτοντας με τρόπο μοναδικό τις αστικές και όχι μόνο μετακινήσεις!Με νέα χρώματα και πλούσιο εξοπλισμό, οι εκδόσεις ELLE και URBAN RIDE, αποτελούν το σημείο αναφοράς για την κατηγορία των μικρών αυτοκινήτων πόλης, καθώς προσφέρουν πολλά περισσότερα από τα συνηθισμένα στο βασικό πακέτο εξοπλισμού τους, συνδυάζοντας ιδανικά το στυλ και τη χαμηλή κατανάλωση!Η νέα έκδοση ELLE εμπλουτίζει και διαφοροποιεί περαιτέρω την ανανεωμένη γκάμα του νέου Citroen C1. Στην έκδοση ELLE κυριαρχούν τα στοιχεία της πολυτέλειας και του εκλεπτυσμένου στυλ, τα οποία αντικατοπτρίζουν τις ανάγκες ενός «δραστήριου» γυναικείου κοινού, που παρακολουθεί το σύγχρονο lifestyle.');
INSERT INTO cars (type_of, brand, model, pers, doors, trans, img_path, descr) VALUES ('2', 'Toyota', 'Yaris', '5','5','auto', 'images/yaris.jpg', 'Το ιαπωνικό SUV έχει μήκος 4,18 μέτρα, είναι υπερυψωμένο κατά 9 εκατοστά ενώ ο χώρος αποσκευών φτάνει τα 397 λίτρα (320 στην έκδοση 4×4).Από πλευράς μηχανικών συνόλων είναι διαθέσιμο με έναν 3κύλινδρο 1.500άρη βενζινοκινητήρα 125 ίππων ο οποίος συνδυάζεται είτε με μηχανικό κιβώτιο 6 σχέσεων είτε με αυτόματο CVT. Επιπλέον υπάρχει και υβριδική έκδοση με κινητήρα χωρητικότητας 1.500 κ.εκ. που αποδίδει 116 ίππους και προσφέρεται αποκλειστικά με αυτόματο κιβώτιο e-CVT. Σε αυτήν την περίπτωση ο πελάτης μπορεί να επιλέξει την έκδοση με την κίνηση στους εμπρός ή ακόμα και στους τέσσερις τροχούς. Ιδίως η τελευταία θα έχει πολύ ενδιαφέρον καθώς υπάρχει ένα σημαντικό κοινό που ενδιαφέρεται για κάτι «μικρό» και με ικανότητες εκτός δρόμου.');
INSERT INTO cars (type_of, brand, model, pers, doors, trans, img_path, descr) VALUES ('1', 'Dacia', 'Duster', '5','5','manual', 'images/duster.jpg', 'Το νέο Dacia Duster κινείται με την ίδια άνεση σε όλα τα οδοστρώματα. Μοντέρνο, στιβαρό και εκθαμβωτικό με το χρώμα Atacama Orange , το νέο Dacia Duster ξέρει να εντυπωσιάζει. Η επιβλητική μπροστινή μάσκα του, τα εμβληματικά φωτιστικά σώματά του και η ελκυστική σχεδίασή του σίγουρα θα τραβήξουν τα βλέμματα. Από τις μπάρες οροφής μέχρι τις ζάντες 16 ιντσών, κάθε στοιχείο του καταδεικνύει ότι είναι σχεδιασμένο για περιπέτεια. Τα πλαϊνά προστατευτικά, όπως και οι εμπρός και πίσω ποδιές κινητήρα, αποτελούν σαφή ένδειξη ότι κανένας δρόμος ή μονοπάτι δεν μπορεί να του αντισταθεί!');
INSERT INTO cars (type_of, brand, model, pers, doors, trans, img_path, descr) VALUES ('1', 'Reanult', 'Megane', '4', '3','manual', 'images/megane.jpg', 'Κομψότητα και σπορ χαρακτήρας. Δερμάτινο τιμόνι και δερμάτινηλαβή μοχλού ταχυτήτων με χρωμιωμένο φιλέτο και ζάντες αλουμινίου17" αναδεικνύουν τον σπορ χαρακτήρα του Megane Dynamic.Γυαλιστερά χρωμιωμένα πλαίσια οργάνων και γυαλιστερές χρωμιωμένες εσωτερικές λαβές ανοίγματος των θυρών, ματ χρωμιωμένο διάζωμα ταμπλό και ματ χρωμιωμένοι υπερυψωμένοι αεραγωγοί δίνουν στο εσωτερικό έναν σπορ χαρακτήρα και ιδιαίτερη κομψότητα. Τα καθίσματα είναι υπενδεδυμένα με ταπετσαρία RenaulteX από teP (απομίμηση δέρματος) και ύφασμα κορυφαίας ποιότητας.');



-- Ο πινακας cars περιέχει πληροφορίες για τα αυτοκίνηταcars

CREATE TABLE users (
	user_id		INT(4)			NOT NULL  PRIMARY KEY AUTO_INCREMENT,
    username	VARCHAR(50)     NOT NULL  UNIQUE,
    password    VARCHAR(50)     NOT NULL,
    email       VARCHAR(50)     NOT NULL,
    lname		VARCHAR(50)     NOT NULL,
    fname   	VARCHAR(50)		NOT NULL,
    tel 	    VARCHAR(15)     NOT NULL,
    privilege   VARCHAR(15)     NOT NULL
);

INSERT INTO users (user_id, username, password, email, lname, fname, tel, privilege) VALUES ('1', 'admin1234', 'admin1234', 'ntinos_31@hotmail.com', 'ADMIN', 'ISTRATOR', '2245022222', 'admin' );


-- bookings

CREATE TABLE bookings (
	booking_id		INT(8)			NOT NULL  PRIMARY KEY AUTO_INCREMENT,
    car_id	        INT(4)          NOT NULL,
    booking_no      VARCHAR(8)      NOT NULL,
    lname	        VARCHAR(50)     NOT NULL,
    fname	     	VARCHAR(50)     NOT NULL,
    email	        VARCHAR(100)    NOT NULL,
    tel 	        VARCHAR(15)     NOT NULL,
    date_start      VARCHAR(10)     NOT NULL,
    date_stop       VARCHAR(10)     NOT NULL,
    time_start      INT(2)          NOT NULL,
    time_stop       INT(2)          NOT NULL,
    spot            VARCHAR(50)		NOT NULL,
    amount          DOUBLE(6, 2) 	NOT NULL,
    days_count		INT(4)          NOT NULL,
    days_order		INT(7)          NOT NULL,
    status          VARCHAR(10)     NOT NULL DEFAULT '0',
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE RESTRICT
);



CREATE TABLE months (           --  αυτός ο πινακας χρησιμεύει για να αποθηκεύονται ποιο μήμες είναι ενεργοι
    m_id	VARCHAR(12) UNIQUE,	--  ωστε όταν προστεθεί καινούριο αυτοκίνητο να τους ενημερώσουμε
	m_month		int(2),
	m_year		int(4)
);




-- Ο πινακας cars##**** έχει ώς όνομα τη λέξη cars ακολουθολυμενη απο 6 ψηφια, τα δύο (#) πρωτα είναι ο μηνα και τα υπολοιπα 4 (*) το έτος πχ cars112021
-- Στο insert έχουμε ως πρώτη τιμη το 1 δηλαδή την πρώτη μερα του μηνα και αυξανεται αυτοματα εώς ότου θελουμε
--  η τιμη NULL σημαίνει ότι ειναι διαθέσιμο για ενοικίαση
-- Nov 2021 (30)