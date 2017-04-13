    <!DOCTYPE html>
    <html>
    <head>
        <title>Restaurant App</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <!script type="text/javascript" src="JS/scriptRegister.js"></script>
    </head>
    <body>
        <h1> Restaurant App <span> <!img src="images/jammer_logo.png" alt="logo" id="imgLogo"> </span> </h1> 
        <div class="register">
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'Restaurant')">Restaurant</button>
                <button class="tablinks" onclick="openCity(event, 'Consumer')">Consumer</button>
            </div>

            <fieldset> <legend>New account registry:</legend>
                <p>First Name:</p> 
                <input id="firstName" type="text" class="formElement" size="20"> 
                <span id="errorLabelFirstName" class="errorLabels"></span>
                <p>Last Name:</p> 
                <input id="lastName" type="text" class="formElement" size="20"> 
                <span id="errorLabelLastName" class="errorLabels"></span>
                <p>Username:</p> 
                <input id="newusername" type="text" class="formElement" size="20"> 
                <span id="errorLabelNewUserName" class="errorLabels" ></span>
                <p>Email:</p> 
                <input id="email" type="text" class="formElement" size="20"> 
                <span id="errorLabelEmail" class="errorLabels"></span>
                <p>Password:</p> 
                <input id="p1" type="password" class="formElement" size="20"> 
                <span id="errorLabelP1" class="errorLabels"></span>
                <p>Password Confirmation:</p>
                <input id="p2"  type="password" class="formElement" size="20"> 
                <span id="errorLabelP2" class="errorLabels"></span>
                <span id="errorLabelPasswordConfirmationMatch" class="errorLabels"></span>
                <p>Country</p>
                <select id="country" name="Country">
                    <option value="0">Select a country...</option>
                    <option value="Mexico">Mexico</option>
                    <option value="USA">USA</option>
                    <option value="UK">UK</option>
                    <option value="Canada">Canada</option>
                    <option value="Brazil">Brazil</option>
                    <option value="Italy">Italy</option>
                    <option value="Spain">Spain</option>
                    <option value="Germany">Germany</option>
                    <option value="Japan">Japan</option>
                    <option value="China">China</option>
                    <option value="Chile">Chile</option>
                    <option value="India">India</option>
                    <option value="South Korea">South Korea</option>
                    <option value="Singapur">Singapur</option>
                </select>
                <span id="errorLabelCountry" class="errorLabels"></span>
                <p>Gender:</p>
                <input id="g1" type="radio" name="gender" value="1"> Male<br>
                <input id="g2" type="radio" name="gender" value="2"> Female<br>
                <span id="errorLabelGender" class="errorLabels"></span>
                <br>
                <input class="buttons" type="submit" id="registerButton" value="Register"/>
                <input class="buttons" type="submit" id="cancelButton" value="Cancel"/>
            </fieldset>
        </div>
    </body>
    <span style="color:steelblue "> <h2>Connecting people since 2017.</h2> </span>
    </html>