<?php
include 'script.php';

// get maintenance criteria setup

$maintenance_criteria_setup = "
    SELECT
        msc.keyctr AS keyctr,
        mai.indicator_description indicator,
        mai.relevance_def relevance_definition,
        mam.description,
        msc.movdocs_reqs documentary_requirements,
        mds.srcdesc data_source
    FROM
        `maintenance_criteria_setup` msc
    left JOIN maintenance_criteria_version AS mcv
    ON
        msc.version_keyctr = mcv.keyctr
    left  JOIN maintenance_area_indicators AS mai
    ON
        msc.indicator_keyctr = mai.keyctr
    left JOIN maintenance_area_mininumreqs AS mam
    ON
        msc.minreqs_keyctr = mam.keyctr
    LEFT JOIN maintenance_document_source AS mds
    ON
        msc.data_source = mds.keyctr order by msc.keyctr  desc
";
$maintenance_criteria_setup_result = mysqli_query($conn, $maintenance_criteria_setup);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="container text-center">
            <div class="row">
                <div class="col-auto me-auto">
                    <h4>Maintenance Criteria Setup</h4>
                </div>
                <div class="col-auto"> <a href="add.php" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Indicator</th>
                    <th>Relevant/Definition </th>
                    <th>Minimum Requirements</th>
                    <th>Documentary Requirements/MOVs</th>
                    <th>Data Source</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($maintenance_criteria_setup_result) > 0) {
                    while ($row = mysqli_fetch_assoc($maintenance_criteria_setup_result)) { ?>
                        <tr>
                            <td>
                                <a href="edit.php?edit_id=<?php echo $row['keyctr'] ?>">Edit</a> |
                                <a href="script.php?delete_id=<?php echo $row['keyctr'] ?>">Delete</a>
                            </td>
                            <td><?php echo $row['indicator']; ?></td>
                            <td><?php echo $row['relevance_definition']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['documentary_requirements']; ?></td>
                            <td><?php echo $row['data_source']; ?></td>
                        </tr>
                    <?php }
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>