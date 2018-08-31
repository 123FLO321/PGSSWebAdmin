<style>
	table.dataTable tbody td {
		text-align: center;
		vertical-align: middle;
	}
    .search-results {
        padding: 0;
        margin: 0;
    }
    .search-results .search-result {
        padding: 0;
        border-top: 1px solid #d8d8d8;
        border-left: 1px solid #d8d8d8;
        border-right: 1px solid #d8d8d8;
        cursor: pointer;
        list-style: none;
        display: flex;
        align-items: center;
    }
    .search-results .search-result .left-column {
        display: flex;
        flex: 1;
        background: #eaeaea;
    }
    .search-results .search-result .left-column:hover {
        background: grey;
        color: #fff;
    }
    .search-results .search-result .left-column-selected {
        display: flex;
        flex: 1;
        background: rgba(0, 0, 255, 0.5);
    }
    .search-results .search-result .left-column-selected:hover {
        background: rgba(0, 0, 255, 0.75);
        color: #fff;
    }

    .search-results .search-result .right-column {
        display: flex;
    }
    .search-results .search-result .right-column .fa {
        font-size: 14px;
        margin-top: 0;
        height: 50px;
        background: #3b3b3b;
        border-radius: 0;
        padding: 0 0.75em;
        color: #fff;
        display: flex;
        align-items: center;
    }
    @media (min-width: 768px) {
        .search-results .search-result .right-column .fa {
            font-size: 24px;
        }
    }
    .search-results .search-result span.i-icon {
        width: 50px !important;
        height: 50px !important;
        min-width: 50px !important;
        display: inline-block;
        background-position: center !important;
        background-size: cover !important;
    }
    .search-results .search-result .cont {
        display: flex;
        align-items: center;
        margin-left: 10px;
        font-size: 12px;
    }
    @media (min-width: 768px) {
        .search-results .search-result .cont {
            font-size: 16px;
        }
    }
    .search {
        width: 100%;
    }
</style>

<?php
include_once "lib/db.php";
include_once 'lib/functions.php';

$fileIdsString = '';
$files = array_diff(scandir(PGSS_ROOT_DIR.'/web_img'), array('.', '..'));
foreach ($files as $file) {
	if (str_contains($file, "GymImage_")) {
	    $fileId = str_replace('GymImage_', '', str_replace('.png', '', $file));
	    if ($fileIdsString === '') {
		    $fileIdsString .= $fileId;
        } else {
		    $fileIdsString .= ', '. $fileId;
	    }
	}
}

if (is_null($id)) {
    $showSkip = true;
    $idQuery = "
      SELECT gi.id
      FROM gym_images gi
      JOIN forts f ON f.id = gi.fort_id
      WHERE f.name = 'UNKNOWN FORT' AND gi.id IN (". $fileIdsString .")
    ";


	$idResults = $db->query($idQuery)->fetchAll(\PDO::FETCH_ASSOC);

    if (sizeof($idResults) === 0) {
	    $isEmpty = true;
    } else {
	    $isEmpty = false;
	    $id = $idResults[array_rand($idResults)]['id'];
    }
} else {
	$showSkip = false;
	$isEmpty = false;
}

if (!$isEmpty) {
	$data = array();

	$query = "
        SELECT gi.id, gi.fort_id, f.name
        FROM gym_images gi
        JOIN forts f on gi.fort_id = f.id
        WHERE gi.id = :id
    ";

	$sth = $db->pdo->prepare($query);
	$sth->bindParam(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	$results = $sth->fetchAll();

	if (sizeof($results) !== 1) {
		die("Can not find id.");
	}
	$result = $results[0];

	$id = $result['id'];
	$fortId = $result['fort_id'];
	$name = $result['name'];
	$url = 'image/GymImage_'.$id.'.png';

    if (!$showSkip && $name !== "UNKNOWN FORT" && $name !== "NOT A FORT") {
		$searchPrefill = $name;
		$preSelect = $fortId;
    } else {
		$searchPrefill = '';
		$preSelect = 0;
	}

}

if ($isEmpty) {
    ?>

    <br>
    <h2 align="center">No Gym Images left to Solve!</h2>
    <br>

	<?php
} else {
    ?>

    <br>
    <div style="width:90%; margin-left:calc(5%);">
        <div class="row">
            <div class="col-md-2">
                <div class="text-center">
                    <h5>Screenshot</h5>
                    <img border="5" src="<?=$url?>" height="300">
                    <br><br>
                    <input type="submit" id="not" class="btn btn-danger" value="Not a Fort">
                    <br>
                    <?php
                    if ($showSkip) {
	                    ?>
                        <br>
                        <a href="solvegyms" role="button" class="btn btn-primary">Skip</a>
	                    <?php
                    }
                    ?>
                </div><br>
            </div>

            <div class="col-md-8">
                <div class="text-center">
                    <h5>Gym</h5>
                    <input class="form-control" type="search" id="search" name="gym-search" data-type="gym" value="<?=$searchPrefill?>">
                    <ul id="gym-search-results" class="search-results gym-results"></ul>
                </div><br>
            </div>

            <div class="col-md-2">
                <div class="text-center">
                    <br>
                    <input type="submit" id="submit" class="btn btn-success" value="Submit Gym Image">
                </div><br>
            </div>
        </div>
    </div>

    <script>

        var preSelect = <?=$preSelect?>;

        $(document).ready(function() {
            $("#search").bind('input', function () {
                searchAjax($("#search"), "gym");
            });
            $("#submit").click(function() {
                submit(false);
            });
            $("#not").click(function() {
                submit(true)
            });
            if (preSelect != 0) {
                searchAjax($("#search"), "gym");
            }
        });


        var indexNow = 0;

        function searchAjax(field, type) {
            var term = field.val();
            indexNow = indexNow + 1;
            var index = indexNow;
            if (term != '') {
                $.ajax({
                    url: 'searchgym/'+term,
                    type: 'POST',
                    timeout: 300000,
                    dataType: 'json',
                    cache: false
                }).done(function (data) {
                    if (data && index == indexNow) {
                        var par = field.parent();
                        var sr = par.find('.search-results');
                        sr.html('');
                        data.forEach(function (element) {
                            var classType;
                            if (preSelect != 0 && preSelect == element.id) {
                                classType = "left-column-selected";
                                preSelect = 0;
                            } else {
                                classType = "left-column";
                            }

                            var html = '<li class="search-result">' +
                                '<div class="'+classType+'" onClick="selectElement(' + element.id + ', \''+type+'\');"' +
                                'data-type = "' + type + '" data-id="' + element.id + '">';
                            if (element.url != '') {
                                html += '<span style="background:url(' + element.url + ') no-repeat;" class="i-icon" ></span>'
                            }
                            html += '<div class="cont"><span class="name" >' + element.name + '</span>';
                            html += '</div></div>';
                            html += '</li>';
                            sr.append(html);
                        })
                    }
                })
            } else {
                var par = field.parent();
                var sr = par.find('.search-results');
                sr.html('');
            }
        }

        function selectElement(id, type) {
            console.log(id, type);
            var arraySelected = document.getElementsByClassName("left-column-selected");
            var arrayNormal = document.getElementsByClassName("left-column");

            for(var i = (arraySelected.length - 1); i >= 0; i--) {
                arraySelected[i].className = "left-column";
            }

            for(var n = (arrayNormal.length - 1); n >= 0; n--) {
                if ($(arrayNormal[n]).attr("data-id") == id) {
                    arrayNormal[n].className = "left-column-selected";
                }
            }
        }

        function submit(forceNot) {
            var gym = -1;
            var id = <?=$id?>;

            var arraySelected = document.getElementsByClassName("left-column-selected");
            for(var i = (arraySelected.length - 1); i >= 0; i--) {
                if ($(arraySelected[i]).attr("data-type") == "gym") {
                    gym = $(arraySelected[i]).attr("data-id")
                }
            }

            if (forceNot) {
                gym = -2
            }

            if (!forceNot && gym == -1) {
                alert("Gym required!")
            } else if (id == null) {
                alert("Error! Please try again later!")
            } else {
                $.post( "submit/gymimage/"+id+"/"+gym )
                    .done(function( data ) {
                        <?php
                            if ($showSkip) {
                                echo 'window.location.href = "solvegyms"';
                            } else {
                                echo 'window.location.href = "checkgyms"';
                            }
                        ?>
                    });
            }
        }
    </script>
	<?php
}
?>