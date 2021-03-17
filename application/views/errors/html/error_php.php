<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
            <title>CodePen - 500 Error - Broken #CodePenChallenge</title>
            <meta name="viewport" content="width=device-width, initial-scale=1"/>
            <style>
                @import url("https://fonts.googleapis.com/css?family=Nunito:400,700");
                * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                }
                html {
                    height: 100%;
                }
                body {
                    background: #fff1f1;
                    font-family: "Nunito", sans-serif;
                }
                .container {
                    width: 75%;
                    max-width: 700px;
                    margin: 1.5rem auto;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                @media (max-width: 650px) {
                    .container {
                        width: 85%;
                    }
                }
                .container .header {
                    color: #fb3958;
                    font-size: 5em;
                    font-weight: 700;
                    text-align: center;
                    text-shadow: 2px 2px 5px #b1041f;
                }
                @media (max-width: 650px) {
                    .container .header {
                        font-size: 3em;
                    }
                }

                .compcontainer {
                    width: 75%;
                    height: 13rem;
                    padding: 1rem 0;
                }
                @media (max-width: 650px) {
                    .compcontainer {
                        height: 10rem;
                    }
                }
                .compcontainer svg {
                    max-width: 100%;
                    max-height: 100%;
                    animation: bouncy 1300ms linear infinite;
                }

                .instructions {
                    background: #FEFEFE;
                    width: 80%;
                    height: auto;
                    padding: 1rem;
                    border: 1px solid #DCDCDC;
                    border-radius: 0.25rem;
                }
                @media (max-width: 650px) {
                    .instructions {
                        width: 100%;
                    }
                }
                .instructions h2 {
                    font-size: 1.25em;
                    line-height: 1.3;
                    color: #e30528;
                }
                @media (max-width: 650px) {
                    .instructions h2 {
                        font-size: 1.05em;
                    }
                }
                .instructions p {
                    font-size: 1.15em;
                    line-height: 1.5;
                    color: #122125;
                }
                @media (max-width: 650px) {
                    .instructions p {
                        font-size: 1em;
                    }
                }
                .instructions .step {
                    display: flex;
                    flex-direction: row;
                    width: 100%;
                    height: 1.5rem;
                    margin: 0.5rem 0;
                }
                .instructions .step .icon {
                    width: 1.25rem;
                    height: 1.25rem;
                    align-self: center;
                }
                @media (max-width: 650px) {
                    .instructions .step .icon {
                        width: 1rem;
                        height: 1rem;
                    }
                }
                .instructions .step p {
                    display: inline-block;
                    width: 80%;
                    line-height: 1.5;
                    padding-left: 0.5rem;
                }

                @keyframes bouncy {
                    0% {
                        transform: translateY(10px) translateX(0) rotate(0);
                    }
                    25% {
                        transform: translateX(-10px) rotate(-10deg);
                    }
                    50% {
                        transform: translateX(0) rotate(0deg);
                    }
                    75% {
                        transform: translateX(10px) rotate(10deg);
                    }
                    100% {
                        transform: translateY(10px) translateX(0) rotate(0);
                    }
                }
            </style>
    </head>
    <body>
        <!-- partial:index.partial.html -->
        <div class="container">
            <div class="compcontainer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90.5 74.769">
                    <path fill="#C7CCDB" d="M58.073 74.769H32.426l6.412-19.236h12.824z"/>
                    <path fill="#373F45" d="M90.5 52.063c0 1.917-2.025 3.471-4.525 3.471H4.525C2.025 55.534 0 53.98 0 52.063V3.471C0 1.554 2.026 0 4.525 0h81.449c2.5 0 4.525 1.554 4.525 3.471v48.592z"/>
                    <path fill="#F1F2F2" d="M84.586 46.889c0 1.509-1.762 2.731-3.936 2.731H9.846c-2.172 0-3.933-1.223-3.933-2.731V8.646c0-1.508 1.761-2.732 3.933-2.732H80.65c2.174 0 3.936 1.225 3.936 2.732v38.243z"/>
                    <path fill="#A2A7A5" d="M16.426 5.913L8.051 23h13l-6.875 12.384L26.75 46.259l-8.375-11.375L26.75 20H14.625l6.801-14.087zM68.551 49.62l-8.375-17.087h13l-6.875-12.384L78.875 9.274 70.5 20.649l8.375 14.884H66.75l6.801 14.087z"/>
                </svg>
            </div>
            <h1 class="header">500 ERROR</h1>
            <div class="instructions">
                <h2>Sorry, something went wrong on our end. We are currently trying to fix the problem.</h2>
                </ul>
            </div>
        </div>
        <!-- partial -->
    </body>
    <div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0; display: none;">
        <h4>A PHP Error was encountered</h4>
        <p>Severity: <?php echo $severity; ?></p>
        <p>Message:  <?php echo $message; ?></p>
        <p>Filename: <?php echo $filepath; ?></p>
        <p>Line Number: <?php echo $line; ?></p>
        <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
            <p>Backtrace:</p>
            <?php foreach (debug_backtrace() as $error): ?>
                <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
                    <p style="margin-left:10px">
                        File: <?php echo $error['file'] ?><br />
                        Line: <?php echo $error['line'] ?><br />
                        Function: <?php echo $error['function'] ?>
                    </p>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</html>
<?php die() ?>