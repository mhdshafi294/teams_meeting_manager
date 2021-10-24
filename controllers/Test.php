<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Test extends AdminController
{
    public function test()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.microsoft.com/v1.0/me/events/AQMkADAwATYwMAItYzAyNi0xMDExAC0wMAItMDAKAEYAAANszKxW1OM6Q4lztWcEh9DoBwD3NDHOhPrjQ7JOSgiS578kAAACAQ0AAAD3NDHOhPrjQ7JOSgiS578kAAVagKebAAAA',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EwB4A8l6BAAUwihrrCrmQ4wuIJX5mbj7rQla6TUAATBoWg/5AWiq731S5jQT7rqKD5CSdssvSeKL9uQltXhV3c/QHXMMmcALJzXHSskAYL42wwwR/IK64hTrT5wvYKm7j9GjbdvSvxOkflU5vUdTOK+VT2bYKh7QqrlF9W3N+lpaVcQYlljzxfVUoPAl7C0lth0G9GDzSbM8akosk0Y/BWYYuEyPgTVaZTZ0f39BioForWma6FtU5drevobZeAPD2TY8qoQ3YVfMy/Q4i9Wd8Pvqg+jPdrO8yozvvNJO1J3mY4oXn+js7c26tBv/oNQ9MBml3gYrlOj6fmHBCagI1kV0/Qrb04+Zp6jhPdUHDp92y9QnVbaZyAd5Khyo9BADZgAACF4ni25pVbIRSAJmkuGAf1vQHT9u1lPUKFAt6JVJVHeV23xPElsOEK7yISx7iitFOLZhow59RJo1ABg7eos3C44Y/F/zDj91NBjti0+ThyYeBRK+7GOSCB/yhOkmPO1hy7SvPQQhr6Qw1c8NsFGpDUsh6RmXphRdleT5xG65gS8P80n+8x+zW0Iiv4p+IJql36SCyJ95uTgQ6ipZkg6nZzvtIZGgGGN5TXhZS8u9IF6Q5SBGpJma8qMs+Z2qTwOduVZ+se1GtFfZvSPPWZDOrxFExLZRkCoTMRNRyUCylz/5tVYOCgd9M36K5WGZIbHVrqHrcq1xGFaqzU3dhq46+gnE4iSKgs3SQ8hWS1IgGW0Snyk5gSJj4b+dtcWgNB9DCGnfAvxPLm/tutLz7WJZv9e2axUdS3tZDv3LRn8Yqoc3nx645dR6kwZVi//DHuVL2vhid66IlIUl/SCRhWpgNixtsHHn4fq9+wSqFfPT8g2Sm0mNGfnauQ4gf9oNDkHGrLzJVpAxTWm8IYVHnKPQM3PW7eotOO3I9LeaS35X47A8hxWH409ImKoNrglQBkvadAYX7DDZPY1ohRD5a+9GaPDXqrXRu3XUYM/ZlOCjDr4rFjwZWG6XoLSSG7UTNCJbMRxht3T+OYKo9noVnY4G7LO6Rd2ZmVrJwT5OCULx7k5KubhfW7oW6L93E5maX+zKw7Aq6KeXj6sMDQj2/KXJuAOBAD0b5IwxGnVINu+aMMPPZkNjbxgx5GGoONEpz63R5Hb9clgfCHKOqApvB4lF/sM0LIwC'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
