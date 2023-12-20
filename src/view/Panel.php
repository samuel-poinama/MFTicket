<?php
require_once __DIR__ . '/../model/Groups.php';


if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

$error = null;

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'invalidName':
            $error = "Invalid Group Name";
            break;
        case 'groupExists':
            $error = "Group Already Exists";
            break;
        case 'canNotDeleteGroup':
            $error = "Can Not Delete Group";
            break;
        case 'groupDoesNotExist':
            $error = "Group Does Not Exist";
            break;
        case 'invalidCredentials':
            $error = "Invalid Credentials";
            break;
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/assets/css/adminPanel.css" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<body>
    <script>
        const showCreateTicket = () => {
            document.getElementById("create_tiket").style.display = "block";
        }

        const hideCreateTicket = () => {
            document.getElementById("create_tiket").style.display = "none";
        }
    </script>

    <div id="create_tiket" class="box" >
        <form action="createTiket" method="post">
            <input type="text" name="name" placeholder="Ticket Name">
            <input type="submit" value="Create tiket" >
            <button onClick="hideCreateTicket()" type="button">close</button>
        </form>
    </div>

    <?php if ($error != null) { ?>
    <div id="error" >
            <strong><?php echo $error ?></strong>
        </div>
    <?php } ?>
    <div id="grid">
        <div id="left_panel">
            <h1>Tikets</h1>
            <ul id="ticket_list">
                <?php
                $tickets = Ticket::getAllTickets();
                foreach ($tickets as $ticket) {
                    echo "<li>{$ticket->getName()}</li>";
                }
                ?>
            </ul>
            <button onClick="showCreateTicket()">
                <img src="/assets/img/plus.png" width="32px" id="plus">
            </button>
        </div>
        <div id="work_space">
            <h1>Operators</h1>
            <div id="table">
                <form id="table_form" action="editTicket" method="post">
                    <table>
                        <tr>
                            <th>Ticket</th>
                            <th>isDone</th>
                        </tr>
                        <tr>
                            <td>
                                <strong><?php echo $user->getTicket()->getName() ?></strong>
                            </td>
                            <td>
                                <input type="checkbox" name="isDone">
                            </td>
                        </tr>
                    </table>
                    <button class="button" type="submit">update</button>
                </form>
            </form>
            </div>
    </div>
</body>
</html>