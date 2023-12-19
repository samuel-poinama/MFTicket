<?php
if (!$_SESSION['creds']->getGroup()->isAdmin()) {
    header("Location: /");
    exit();
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
    <div id="grid">
        <div id="groups">
            <h1>Groups</h1>
            <ul id="groups_list">
                <?php
                $groups = Group::getGroups();
                foreach ($groups as $group) {
                
                    echo "<li>
                            <a href='?group=$group'>
                                $group
                            </a>
                        </li>";
                }
                ?>
            </ul>
        </div>
        <div id="operators">
            <h1>Operators</h1>
            <div id="table">
                <table>
                    <tr>
                        <th>Person</th>
                        <th>Group</th>
                        <th>Task</th>
                        <th>isDone</th>
                    </tr>
                    <?php
                        $allUsers = Credentials::getAllUSersEmailsWithGroup();

                        foreach ($allUsers as $user) {
                            echo "<tr>
                                    <td>{$user->getEmail()}</td>
                                    <td>{$user->getGroup()->getName()}</td>";

                            if ($user->getTask() == null) {
                                echo "<td>Not Assigned</td>";
                                echo "<td>Not Assigned</td>";
                            } else {
                                echo "<td>{$user->getTask()->getName()}</td>";
                                if ($user->getTask()->isDone()) {
                                    echo "<td>Done</td>";
                                } else {
                                    echo "<td>Not Done</td>";
                                }
                            }

                            echo "</tr>";

                            
                        }
                    ?>
                </table>
            </div>
    </div>
</body>
</html>