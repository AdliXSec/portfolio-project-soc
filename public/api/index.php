<?php
header('Content-Type: application/json');

echo json_encode([
    "data" => [
        "hero" => "ini foto hero",
        "about" => [
            "img" => "ini foto about",
            "judul" => "ini judul about",
            "deskripsi" => "ini deskripsi about",
            "skill" => [75, 85, 80, 88],
            "sosmed" => [
                "ig" => "link ig",
                "in" => "link in",
                "wa" => "link wa",
                "tt" => "link tt",
                "x" => "link x",
                "gh" => "link gh"
            ]
        ],
        "tech" => [
            "php" => [
                "judul" => "php",
                "svg" => "php"
            ],
            "js" => [
                "judul" => "js",
                "svg" => "js"
            ],
            "py" => [
                "judul" => "py",
                "svg" => "py"
            ],
            "go" => [
                "judul" => "go",
                "svg" => "go"
            ],
            "mysql" => [
                "judul" => "mysql",
                "svg" => "mysql"
            ],
            "java" => [
                "judul" => "java",
                "svg" => "java"
            ],
            "cpp" => [
                "judul" => "cpp",
                "svg" => "cpp"
            ],
            "cs" => [
                "judul" => "cs",
                "svg" => "cs"
            ],
            "css" => [
                "judul" => "css",
                "svg" => "css"
            ],
            "nodejs" => [
                "judul" => "nodejs",
                "svg" => "nodejs"
            ],
            "reactjs" => [
                "judul" => "reactjs",
                "svg" => "reactjs"
            ],
            "arduino" => [
                "judul" => "arduino",
                "svg" => "arduino"
            ]
        ],
        "project" => [
            "project1" => [
                "judu" => "project1",
                "deskripsi" => "project1",
                "link" => "project1"
            ],
            "project2" => [
                "judu" => "project2",
                "deskripsi" => "project2",
                "link" => "project2"
            ],
            "project3" => [
                "judu" => "project3",
                "deskripsi" => "project3",
                "link" => "project3"
            ],
            "project4" => [
                "judu" => "project4",
                "deskripsi" => "project4",
                "link" => "project4"
            ]
        ],
        "contact" => "link cv" 
    ]
], JSON_PRETTY_PRINT);
