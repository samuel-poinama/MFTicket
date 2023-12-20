<?php
require_once __DIR__ . '/../model/Groups.php';

if (!array_key_exists('user', $_SESSION) || !$_SESSION['user']->getGroup()->isAdmin()) {
    header("Location: /login");
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
        function showCreateGroup() {
            document.getElementById("create_group").style.display = "block";
        }

        function hideCreateGroup() {
            document.getElementById("create_group").style.display = "none";
        }
    </script>

    <div id="create_group" >
        <form action="createGroup" method="post">
            <input type="text" name="name" placeholder="Group Name">
            <input type="submit" value="Create">
            <button onClick="hideCreateGroup()" type="button">close</button>
        </form>
    </div>
    <?php if ($error != null) { ?>
    <div id="error" >
            <strong><?php echo $error ?></strong>
        </div>
    <?php } ?>
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
            <button onClick="showCreateGroup()">
                <img src="/assets/img/plus.png" width="32px" id="plus">
            </button>
        </div>
        <div id="operators">
            <h1>Operators</h1>
            <div id="table">
                <form id="table_form" action="" method="post">
                    <table>
                        <tr>
                            <th>id</th>
                            <th>Person</th>
                            <th>Group</th>
                            <th>Task</th>
                            <th>isDone</th>
                        </tr>
                        <?php
                        $group = $_GET['group'] ?? 'admin';
                            $allUsers = User::getAllUsersEmailByGroup($group);
                            foreach ($allUsers as $user) {
                                echo "<tr>
                                        <td>{$user->getId()}</td>
                                        <td>{$user->getEmail()}</td>
                                        <td>
                                        <select name='{$user->getId()}_group' >
                                            <option value='{$group}'>$group</option>
                                            ";

                                foreach ($groups as $i) {
                                    if ($group != $i) {
                                        echo "<option value='{$i}'>$i</option>";
                                    }
                                }
    
                                echo "</select>
                                        </td>";

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
                    <button type="submit">update</button>
                </form>
                <form id="remove" method="post" action="removeGroup" >
                <button type="submit" name="group" value=<?php echo $group ?> >
                    <img src="/assets/img/remove.png" width="32px" id="remove">
                </button>
            </form>
            </div>
    </div>
</body>
</html>