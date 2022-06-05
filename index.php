<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarSpace </title>
    
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <!-- Connector untuk menghubungkan PHP dan SPARQL -->
    <?php
        require_once("sparqllib.php");
        $searchInput = "" ;
        $filter = "" ;
        
        if (isset($_POST['search'])) {
            $searchInput = $_POST['search'];
            $data = sparql_get(
            "http://localhost:3030/carspace",
            "
                prefix id: <https://carspace.com/mobil#> 
                prefix k: <https://carspace.com/mobil/komponen#> 

                SELECT ?nama ?merek ?jenisMobil ?kapasitasMesin ?tenaga ?bahanBakar ?harga ?tempatDuduk 
                WHERE
                { 
                    ?mobil
                        k:nama                  ?nama;
                        k:merek                 ?merek;
                        k:jenisMobil            ?jenisMobil;
                        k:kapasitasMesin        ?kapasitasMesin;
                        k:tenaga                ?tenaga;  
                        k:bahanBakar            ?bahanBakar;
                        k:harga                 ?harga;
                        k:tempatDuduk           ?tempatDuduk.
                        FILTER 
                        (regex (?nama, '$searchInput', 'i') 
                        || regex (?merek, '$searchInput', 'i') 
                        || regex (?jenisMobil, '$searchInput', 'i') 
                        || regex (?kapasitasMesin, '$searchInput', 'i') 
                        || regex (?tenaga, '$searchInput', 'i') 
                        || regex (?bahanBakar, '$searchInput', 'i') 
                        || regex (?harga, '$searchInput', 'i') 
                        || regex (?tempatDuduk, '$searchInput', 'i')) 
                }
            "
            );
        } else {
            $data = sparql_get(
            "http://localhost:3030/carspace",
            "
                prefix id: <https://carspace.com/mobil#> 
                prefix k: <https://carspace.com/mobil/komponen#>
                
                SELECT ?nama ?merek ?jenisMobil ?kapasitasMesin ?tenaga ?bahanBakar ?harga ?tempatDuduk
                WHERE
                { 
                    ?mobil
                        k:nama                  ?nama;
                        k:merek                 ?merek;
                        k:jenisMobil            ?jenisMobil;
                        k:kapasitasMesin        ?kapasitasMesin;
                        k:tenaga                ?tenaga;  
                        k:bahanBakar            ?bahanBakar;
                        k:harga                 ?harga;
                        k:tempatDuduk           ?tempatDuduk.
                }
            "
            );
        }

        if (!isset($data)) {
            print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
        }
    ?>
    
    <!-- Navbar -->
    <div class="navbar">
            <a href="index.php"><img src="src/Carspace.png" alt="logo"></a>
        </div>
        
        <div class="search_bar">
            <form role="search" action="" method="post" id="search" name="search">
                <input class="input_search_bar" type="search" placeholder="Cari Mobil Idamanmu" aria-label="Search" name="search">
                <button class="button" type="submit">Search</button>
            </form>
        </div>

    <!-- Body -->
    
        <?php
            if ($searchInput != NULL) {
                ?> 
                    <div class="result">
                        <span>Result of <b>"<?php echo $searchInput; ?>"</b></span> 
                    </div>
                <?php
            }
        ?>
    <div class="table_container">    
        <table >
            <thead >
                <tr>
                    <th>No.</th>
                    <th>Nama mobil</th>
                    <th>Merek</th>
                    <th>Jenis Mobil</th>
                    <th>Kapasitas Mesin</th>
                    <th>Tenaga</th>
                    <th>Bahan Bakar</th>
                    <th>Harga</th>
                    <th>Tempat Duduk</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($data as $data) : ?>
                    <td><?= ++$i ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['merek'] ?></td>
                    <td><?= $data['jenisMobil'] ?></td>
                    <td><?= $data['kapasitasMesin'] ?></td>
                    <td><?= $data['tenaga'] ?></td>
                    <td><?= $data['bahanBakar'] ?></td>
                    <td><?= $data['harga'] ?></td>
                    <td><?= $data['tempatDuduk'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
        <footer class="footer">
            Mochammad Ghifari Eka Narayana - 140810190021 
        </Footer>
    </body>
</html>