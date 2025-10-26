<?php

if( isset( $_REQUEST[ 'Submit' ] ) ) {
    $id = $_REQUEST[ 'id' ];

    switch ($_DVWA['SQLI_DB']) {
        case MYSQL:
            $conn = $GLOBALS["_mysqli_ston"];

            $stmt = mysqli_prepare($conn, "SELECT first_name, last_name FROM users WHERE user_id = ?");

            mysqli_stmt_bind_param($stmt, "s", $id);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            while( $row = mysqli_fetch_assoc( $result ) ) {
                $first = $row["first_name"];
                $last  = $row["last_name"];

                $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Last name: {$last}</pre>";
            }

            mysqli_close($conn);
            break;

        case SQLITE:
            global $sqlite_db_connection;

            $stmt = $sqlite_db_connection->prepare('SELECT first_name, last_name FROM users WHERE user_id = :id');
            $stmt->bindValue(':id', $id, SQLITE3_TEXT);
            $result = $stmt->execute();

            while ($row = $result->fetchArray()) {
                $first = $row["first_name"];
                $last  = $row["last_name"];

                $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Last name: {$last}</pre>";
            }
            break;
    }
}

?>
