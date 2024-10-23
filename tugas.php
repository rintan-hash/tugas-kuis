<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuis Umum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: auto; /* Allow body to scroll if needed */
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            max-height: 90vh; /* Limit height to 90% of viewport */
            overflow-y: auto; /* Enable vertical scroll if content exceeds max-height */
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .question {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .options {
            list-style-type: none;
            padding: 0;
        }
        .options li {
            margin-bottom: 5px;
        }
        .options li label {
            cursor: pointer;
        }
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 10px 0;
        }
        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        input[type="submit"], button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        .result {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 8px;
        }
        .result h2 {
            margin-bottom: 10px;
        }
        .explanation {
            margin-top: 20px;
            text-align: left;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kuis Pengetahuan Umum</h1>
        <form method="POST" action="">
            <?php
                session_start();

                if (!isset($_SESSION['nama']) && isset($_POST['nama']) && isset($_POST['nim'])) {
                    $_SESSION['nama'] = $_POST['nama'];
                    $_SESSION['nim'] = $_POST['nim'];
                    $_SESSION['currentQuestion'] = 0;
                    $_SESSION['answers'] = [];
                }

                if (!isset($_SESSION['nama'])) {
                    echo '<div class="form-group">';
                    echo '<label for="nama">Nama:</label>';
                    echo '<input type="text" id="nama" name="nama" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="nim">NIM:</label>';
                    echo '<input type="text" id="nim" name="nim" required>';
                    echo '</div>';
                    echo '<input type="submit" value="Mulai Kuis">';
                } else {
                    $questions = [
                        ["question" => "Bunga apakah ini?", "image" => "bunga.jpg", "options" => ["Bunga Edelwis", "Bunga Matahari", "Bunga Melati", "Bunga Mawar", "Bunga Tulip"], "correct" => "Bunga Tulip", "explanation" => "Tulip biasanya memiliki bunga berbentuk cangkir dalam hampir semua warna kecuali biru asli. Bunganya bisa tunggal atau ganda, berjumbai atau terpilin, beraroma atau tidak."],
                        ["question" => "Siapa presiden pertama RI?", "image" => "", "options" => ["Albert Einstein", "Thomas Edison", "Soekarno", "Nikola Tesla", "B.J. Habibie"], "correct" => "Soekarno", "explanation" => "Soekarno adalah presiden pertama Indonesia, menjabat sejak tahun 1945."],
                        ["question" => "Apa ibukota Indonesia?", "image" => "monas.jpg", "options" => ["Bandung", "Surabaya", "Makassar", "Medan", "Jakarta"], "correct" => "Jakarta", "explanation" => "Jakarta telah menjadi ibukota Indonesia sejak kemerdekaan."],
                        ["question" => "Berapa hasil dari 3 x 3?", "image" => "", "options" => ["6", "9", "12", "3", "15"], "correct" => "9", "explanation" => "3 x 3 = 9 adalah operasi dasar perkalian."],
                        ["question" => "Siapa nama tokoh penemu listrik pada gambar di bawah ini?", "image" => "michael.jpeg", "options" => ["Albert Einstein", "Thomas Edison", "Nikola Tesla", "Michael Faraday", "James Watt"], "correct" => "Michael Faraday", "explanation" => "Michael Faraday dikenal sebagai bapak listrik, karena kontribusi yang besar bagi masyarakat dunia di bidang listrik. la lahir dalam keluarga miskin di London, pada tanggal 22 September 1791"],
                        ["question" => "Apa kepanjangan dari NASA?", "image" => "", "options" => ["National Air Space Administration", "National Aeronautics and Space Administration", "National Aeronautics and Space Agency", "National Aerospace Agency", "National Aviation and Space Administration"], "correct" => "National Aeronautics and Space Administration", "explanation" => "NASA adalah singkatan dari National Aeronautics and Space Administration."],
                        ["question" => "Apa nama hewan tercepat di darat?", "image" => "", "options" => ["Cheetah", "Singa", "Macan Tutul", "Serigala", "Kuda"], "correct" => "Cheetah", "explanation" => "Cheetah adalah hewan darat tercepat, mampu mencapai kecepatan hingga 120 km/jam."],
                        ["question" => "Berapakah jumlah provinsi di Indonesia?", "image" => "", "options" => ["33", "38", "35", "32", "36"], "correct" => "38", "explanation" => "Jumlah provinsi di Indonesia pada tahun 2024 adalah 38 provinsi"],
                        ["question" => "Apa ibu kota Jepang?", "image" => "", "options" => ["Osaka", "Nagoya", "Tokyo", "Kyoto", "Sapporo"], "correct" => "Tokyo", "explanation" => "Tokyo adalah ibu kota Jepang yang menjadi pusat ekonomi dan politik negara tersebut."],
                        ["question" => "Siapa penulis buku 'Harry Potter'?", "image" => "", "options" => ["J.K. Rowling", "J.R.R. Tolkien", "George R.R. Martin", "Suzanne Collins", "C.S. Lewis"], "correct" => "J.K. Rowling", "explanation" => "J.K. Rowling adalah penulis dari seri novel Harry Potter yang terkenal."]
                    ];

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['answer'])) {
                            $_SESSION['answers'][$_SESSION['currentQuestion']] = $_POST['answer'];
                        }
                        if (isset($_POST['next'])) {
                            $_SESSION['currentQuestion']++;
                        } elseif (isset($_POST['prev'])) {
                            $_SESSION['currentQuestion']--;
                        } elseif (isset($_POST['submit'])) {
                            $score = 0;
                            echo "<div class='result'><h2>Hasil Kuis</h2>";
                            foreach ($questions as $index => $q) {
                                $userAnswer = isset($_SESSION['answers'][$index]) ? $_SESSION['answers'][$index] : 'Tidak Dijawab';
                                $isCorrect = $userAnswer == $q['correct'];
                                if ($isCorrect) {
                                    $score++;
                                }
                                echo "<p>Soal " . ($index + 1) . ": " . $q['question'] . "</p>";
                                echo "<p>Jawaban Anda: $userAnswer</p>";
                                echo "<p>Jawaban Benar: " . $q['correct'] . "</p>";
                                echo "<div class='explanation'><strong>Penjelasan:</strong> " . $q['explanation'] . "</div>";
                                echo "<hr>";
                            }
                            $total = count($questions);
                            echo "<p>Skor Anda: $score dari $total</p></div>";
                            echo '<form method="POST"><input type="submit" name="restart" value="Mulai Kuis Lagi"></form>';
                            session_destroy();
                            exit();
                        }
                    }

                    $currentQuestion = $_SESSION['currentQuestion'];
                    $q = $questions[$currentQuestion];
                    echo "<div class='question'>";
                    echo "<p>" . ($currentQuestion + 1) . ". " . $q['question'] . "</p>";
                    if ($q['image'] != "") {
                        echo "<img src='" . $q['image'] . "' alt='Gambar untuk soal'>";
                    }
                    $options = $q['options'];
                    shuffle($options);
                    $labels = ["A", "B", "C", "D", "E"];
                    echo "<ul class='options'>";
                    foreach ($options as $i => $opt) {
                        $checked = isset($_SESSION['answers'][$currentQuestion]) && $_SESSION['answers'][$currentQuestion] == $opt ? 'checked' : '';
                        echo "<li><label><input type='radio' name='answer' value='$opt' required $checked> " . $labels[$i] . ". $opt</label></li>";
                    }
                    echo "</ul></div>";
                    echo "<div class='navigation'>";
                    if ($currentQuestion > 0) {
                        echo "<button type='submit' name='prev'>Previous</button>";
                    }
                    if ($currentQuestion < count($questions) - 1) {
                        echo "<button type='submit' name='next'>Next</button>";
                    } else {
                        echo "<input type='submit' name='submit' value='Submit'>";
                    }
                    echo "</div>";
                }
            ?>
        </form>
    </div>
</body>
</html>
