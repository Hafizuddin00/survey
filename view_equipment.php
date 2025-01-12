<?php include 'db_connect.php'; ?>

<?php
// Fetch category and recipe details
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT c.*, r.recipe_id FROM categories c LEFT JOIN receipe r ON c.recipe_name = r.recipe_name WHERE c.id = " . $_GET['id'])->fetch_array();

    foreach ($qry as $k => $v) {
        $$k = $v;
    }
}

// Fetch all the equipment for Set A, Set B, and Set C
$sql_equipment = "SELECT * FROM equipment_details WHERE eq_id IN ('E101', 'E102', 'E103')";
$query_equipment = $conn->query($sql_equipment);
$equipment_list = $query_equipment->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Section</th>
                <th>Details</th>
                <th>Used</th>
                <th>Not Used</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Machine & Utility</strong></td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E101') {
                                echo "<li>" . htmlspecialchars($equipment['spec_id']) . " : " . htmlspecialchars($equipment['eq_description']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E101') {
                                echo "<li>" . htmlspecialchars($equipment['eq_used']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E101') {
                                echo "<li>" . htmlspecialchars($equipment['eq_not_used']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td><strong>Tools</strong></td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E102') {
                                echo "<li>" . htmlspecialchars($equipment['spec_id']) . " : " . htmlspecialchars($equipment['eq_description']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E102') {
                                echo "<li>" . htmlspecialchars($equipment['eq_used']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E102') {
                                echo "<li>" . htmlspecialchars($equipment['eq_not_used']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td><strong>Bakeware</strong></td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E103') {
                                echo "<li>" . htmlspecialchars($equipment['spec_id']) . " : " . htmlspecialchars($equipment['eq_description']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E103') {
                                echo "<li>" . htmlspecialchars($equipment['eq_used']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        foreach ($equipment_list as $equipment) {
                            if ($equipment['eq_id'] == 'E103') {
                                echo "<li>" . htmlspecialchars($equipment['eq_not_used']) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table th, table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color: #f4f4f4;
        font-weight: bold;
        text-transform: uppercase;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    ul li {
        margin-bottom: 10px;
        font-size: 16px;
    }
</style>
