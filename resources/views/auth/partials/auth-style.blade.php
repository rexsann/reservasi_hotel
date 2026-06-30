    <style>
        :root {
            --primary-green: #4F6F52;
            --dark-green: #3A5A40;
            --soft-green: #739072;
            --sage-green: #A9B388;
            --light-green: #DAD7CD;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body.stayzy-auth {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            padding: 20px;

            background: linear-gradient(
                135deg,
                #3A5A40 0%,
                #4F6F52 40%,
                #739072 100%
            );
        }

        /* Background Glow */

        .stayzy-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        .glow-tl {
            top: -10%;
            left: -10%;
            width: 450px;
            height: 450px;
            background: #3A5A40;
            opacity: .4;
        }

        .glow-tr {
            top: -10%;
            right: -10%;
            width: 450px;
            height: 450px;
            background: #A9B388;
            opacity: .3;
        }

        .glow-bl {
            bottom: -10%;
            left: -10%;
            width: 450px;
            height: 450px;
            background: #739072;
            opacity: .35;
        }

        .glow-br {
            bottom: -10%;
            right: -10%;
            width: 450px;
            height: 450px;
            background: #DAD7CD;
            opacity: .25;
        }

        /* Floating Shapes */

        .stayzy-blob {
            position: fixed;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.1);
            backdrop-filter: blur(10px);
            z-index: 0;
        }

        .blob-1 {
            width: 100px;
            height: 100px;
            top: 15%;
            right: 12%;
        }

        .blob-2 {
            width: 140px;
            height: 140px;
            bottom: 12%;
            left: 10%;
        }

        .blob-3 {
            width: 60px;
            height: 60px;
            left: 8%;
            top: 50%;
        }

        /* Card */

        .stayzy-card {
            position: relative;
            z-index: 10;

            width: 100%;
            max-width: 400px;

            background: rgba(255,255,255,.97);
            backdrop-filter: blur(12px);

            border-radius: 20px;

            padding: 35px;

            border: 1px solid rgba(255,255,255,.5);

            box-shadow:
                0 10px 30px rgba(0,0,0,.08);
        }

        /* Header */

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #243126;
            margin-bottom: 6px;
        }

        .auth-header p {
            font-size: 14px;
            color: #7b857c;
        }

        /* Form */

        .stayzy-field {
            margin-bottom: 18px;
        }

        .stayzy-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #344336;
        }

        .stayzy-input-wrap {
            position: relative;
        }

        .stayzy-input {
            width: 100%;
            height: 50px;

            padding: 0 15px;

            border-radius: 10px;
            border: 1px solid #dfe4df;

            background: #fff;

            font-size: 14px;
            outline: none;

            transition: .2s ease;
        }

        .stayzy-input:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(79,111,82,.12);
        }

        .stayzy-input.has-error {
            border-color: #dc4c4c;
        }

        .stayzy-error {
            color: #dc4c4c;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Eye Button */

        .stayzy-input-icon-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);

            border: none;
            background: transparent;
            cursor: pointer;
            color: #7b857c;
        }

        /* Button */

        .stayzy-btn {
            width: 100%;
            height: 50px;

            border: none;
            border-radius: 10px;

            background: linear-gradient(
                135deg,
                #4F6F52,
                #739072
            );

            color: white;
            font-weight: 600;
            font-size: 15px;

            cursor: pointer;
            transition: .3s ease;
        }

        .stayzy-btn:hover {
            transform: translateY(-2px);
        }

        /* Footer */

        .stayzy-meta-row {
            margin-top: 20px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            font-size: 13px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .stayzy-link {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 600;
        }

        .stayzy-link:hover {
            color: var(--dark-green);
        }

        .stayzy-alert-success {
            background: var(--primary-green);
            color: white;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }
    </style>