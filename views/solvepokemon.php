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
include_once "lib/functions.php";


if (is_null($id)) {
	$showSkip = true;
	$idQuery = "
      	SELECT id
		FROM pokemon_images
		WHERE pokemon_id = 0
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
        SELECT id, pokemon_id, form
		FROM pokemon_images
		WHERE id = :id
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
	$pokemonId = $result['pokemon_id'];
	$form = $result['form'];
	$url = 'image/PokemonImage_'.$id.'.png';

	if (!$showSkip && $pokemonId != 0 && $pokemonId != -2) {
		$searchPrefill = getPokemonName($pokemonId, $form);
		if (is_null($form)) {
			if ($pokemonId == 201 || $pokemonId == 351 || $pokemonId == 386 || $pokemonId == 327) {
				$formReal = 11;
			} else {
				$formReal = 0;
			}
		} else {
			$formReal = $form;
		}
		$preSelect = sprintf('%03d',$pokemonId).'_'.sprintf('%02d',$formReal);
	} else {
		$searchPrefill = '';
		$preSelect = 0;
	}

}

if ($isEmpty) {
	?>

	<br>
	<h2 align="center">No Pokemon Images left to Solve!</h2>
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
                    <input type="submit" id="not" class="btn btn-danger" value="Not a Pokemon">
                    <br>
                    <?php
                    if ($showSkip) {
                        ?>
                        <br>
                        <a href="solvepokemon" role="button" class="btn btn-primary">Skip</a>
                        <?php
                    }
                    ?>
                </div><br>
            </div>

            <div class="col-md-8">
                <div class="text-center">
                    <h5>Pokemon</h5>
                    <input class="form-control" type="search" id="search" name="pokemon-search" data-type="gym" value="<?=$searchPrefill?>">
                    <ul id="pokemon-search-results" class="search-results gym-results"></ul>
                </div><br>
            </div>

            <div class="col-md-2">
                <div class="text-center">
                    <br>
                    <input type="submit" id="submit" class="btn btn-success" value="Submit Pokemon Image">
                </div><br>
            </div>
        </div>
    </div>
    <script>

        var preSelect = '<?=$preSelect?>';

        $(document).ready(function() {
            $("#search").bind('input', function () {
                searchAjax($("#search"), "pokemon");
            });
            $("#submit").click(function() {
                submit(false);
            });
            $("#not").click(function() {
                submit(true)
            });
            if (preSelect != 0) {
                searchAjax($("#search"), "pokemon");
            }
        });


        var indexNow = 0;

        function searchAjax(field, type) {
            var term = field.val();
            indexNow = indexNow + 1;
            var index = indexNow;
            if (term != '') {
                $.ajax({
                    url: 'searchpokemon/'+term,
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
                                '<div class="'+classType+'" onClick="selectElement(\'' + element.id + '\', \''+type+'\');"' +
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
            var pokemon = 0;
            var id = <?=$id?>;

            var arraySelected = document.getElementsByClassName("left-column-selected");
            for(var i = (arraySelected.length - 1); i >= 0; i--) {
                if ($(arraySelected[i]).attr("data-type") == "pokemon") {
                    pokemon = $(arraySelected[i]).attr("data-id")
                }
            }

            if (forceNot) {
                pokemon = "-2_0"
            }

            if (!forceNot && pokemon == 0) {
                alert("Pokemon required!")
            } else if (id == null) {
                alert("Error! Please try again later!")
            } else {
                pokemon = pokemon.replace('_', '/');
                $.post( "submit/pokemonimage/"+id+"/"+pokemon )
                    .done(function( data ) {
                        <?php
                        if ($showSkip) {
                            echo 'window.location.href = "solvepokemon"';
                        } else {
                            echo 'window.location.href = "checkpokemon"';
                        }
                        ?>
                    });
            }
        }
    </script>
    <?php
}
?>