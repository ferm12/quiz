@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('content')

<div class="content container">

    @if (isset($errorMsg))
        <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
    @endif

    <label id="required-label" style="margin-left:0px;"><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>

    <form id="sbcc-form" role="form" method="post" action="{{ url('user/register') }}">

        {{ csrf_field() }}
       <div class="form-group">
            <label><span class="span-required-red">*</span>First Name:</label>
            <input type="text" name="first_name" class="form-control" id="first-name" value="{{ old('first_name') }}" required >
            @if ($errors->has('first_name'))
                <span class="help-block alert-danger">
                    <strong>The first name may only contain letters and numbers, no white space</strong>
                </span>
            @endif

        </div>

         <div class="form-group">
            <label><span class="span-required-red">*</span>Last Name:</label>
            <input type="text" name="last_name" class="form-control" id="last-name" value="{{ old('last_name') }}" required >
            @if ($errors->has('last_name'))
                <span class="help-block alert-danger">
                    <strong>The last name may only contain letters and numbers, no white space</strong>
                </span>
            @endif

        </div>
         
        <div class="form-group">
            <label><span class="span-required-red">*</span>Email:</label>

            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required >
            @if ($errors->has('email'))
                <span class="help-block alert-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                    <strong>Also, please note that we have suspended personal e-mail registration like @gmail, @yahoo, @hotmail, @live, @aol, and @outlook. You can only use your company or business e-mail.</strong>
                </span>
            @endif

        </div> 

        <div class="form-group">
            <label><span class="span-required-red">*</span>Phone:</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}" required >
            @if ($errors->has('phone'))
                <span class="help-block alert-danger">
                    <strong>1.The phone may contain letters, numbers, and</strong><br>
                    <strong>2.Any of these -_+*() special characters </strong>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label><span class="span-required-red">*</span>Organization Name:</label>
            <input type="text" name="organization_name" class="form-control" id="organization-name" value="{{ old('organization_name') }}" required >
            @if ($errors->has('organization_name'))
                <span class="help-block alert-danger">
                    <strong>1.The organization name may contain letters, numbers and</strong><br/>
                    <strong>2.Any of these -_+.,!@$%^*() special characters</strong>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label><span class="span-required-red">*</span>Street Address:</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}" required >
            @if ($errors->has('address'))
                <span class="help-block alert-danger">
                    <strong>1.The street address may contain letters, numbers and</strong><br/>
                    <strong>2.Any of these -_+.,!@$%^*() special characters</strong>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label><span class="span-required-red">*</span>City:</label>
            <input type="text" name= "city" class="form-control" id="city" value="{{ old('city') }}" required >
            @if ($errors->has('city'))
                <span class="help-block alert-danger">
                    <strong>The city may only contain letters and numbers</strong><br/>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label><span class="span-required-red">*</span>State/Province:</label>
            <input type="text" name="state" class="form-control" id="state" value="{{ old('state') }}" required >
            @if ($errors->has('state'))
                <span class="help-block alert-danger">
                    <strong>The state may only contain letters and numbers</strong><br/>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label><span class="span-required-red">*</span>Zip Code/Postal Code:</label>
            <input type="text" name="zip_code" class="form-control" id="zip-code" value="{{ old('zip_code') }}" required>
            @if ($errors->has('zip_code'))
                <span class="help-block alert-danger">
                    <strong>The zip code may only contain letters and numbers</strong><br/>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label><span class="span-required-red">*</span>Country:</label>
            <select name="country" id="country" class="form-control" required>
                @if (old('country'))
                    <option selected value="{{old('country')}}">{{ old('country') }}</option>
                @else
                    <option value="">Select Country</option>
                @endif

                <option value="Afghanistan">Afghanistan</option>
                <option value="Åland Islands">Åland Islands</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darrussalam">Brunei Darrussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos Islands">Cocos Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
                <option value="Congo, Republic of the">Congo, Republic of the</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Curaçao">Curaçao</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Eswatini (Swaziland)">Eswatini (Swaziland)</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands">Falkland Islands</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guernsey">Guernsey</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-Bissau">Guinea-Bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
                <option value="Holy See">Holy See</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran">Iran</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jersey">Jersey</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libya">Libya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macau">Macau</option>
                <option value="Macedonia">Macedonia</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia">Micronesia</option>
                <option value="Moldova">Moldova</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="North Korea">North Korea</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestine, State of">Palestine, State of</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Réunion">Réunion</option>
                <option value="Romania">Romania</option>
                <option value="Russia">Russia</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Barthélemy">Saint Barthélemy</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Martin">Saint Martin</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Sint Maarten">Sint Maarten</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia">South Georgia</option>
                <option value="South Korea">South Korea</option>
                <option value="South Sudan">South Sudan</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syria">Syria</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania">Tanzania</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-Leste">Timor-Leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="Uruguay">Uruguay</option>
                <option value="US Minor Outlying Islands">US Minor Outlying Islands</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Vietnam">Vietnam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
            </select>
        </div>

        <div class="form-group">
            <label><span class="span-required-red">*</span>Purchased From:</label>
            <input type="text" name="purchased_from" class="form-control" id="purchased_from" value="{{ old('purchased_from') }}" required>
            @if ($errors->has('purchased_from'))
                <span class="help-block alert-danger">
                    <strong>1.The purchased from may only contain letters, numbers and</strong><br/>
                    <strong>2.Any of these -_+.,!@$%^*() special characters</strong>
                </span>
            @endif

        </div>


        <div class="form-group row ">
            <label for="password" class="col-md-4 col-form-label text-md-right" style="width:15%;"><span class="span-required-red">*</span>{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                <small class="form-text text-muted">Must be at least 6 characters long.</small>

                @if ($errors->has('password'))
                    <div class="invalid-feedback alert-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong><br/></strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right" style="width:15%;"><span class="span-required-red">*</span>{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>


         <br/><br/>
        <!-- <input type="submit" value="Submit" class="btn btn&#45;primary"> -->

            <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                <label for="captcha"><span class="span-required-red">*</span>{{ trans('customer.label_captcha') }}</label>
                <input type="text" id="captcha" name="captcha" class="form-control" placeholder="{{ trans('customer.label_captcha_notice') }}">

                <img src="{{ url('user/captcha/create') }}"
                     onclick="this.src='{{ url('user/captcha/create') }}?r='+Math.random();" 
                     alt="" title="{{ trans('customer.label_captcha_tips') }}" class="img-captcha-small">

                <p style="margin-top: 3px;">{{ trans('customer.label_captcha_tips') }}</p>

                @if ($errors->has('captcha'))
                    <span class="help-block alert-danger">
                        <strong>{{ $errors->first('captcha') }}</strong>
                    </span>
                @endif
            </div>

            <p>&nbsp;</p>

            <div class="form-group">
                <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                <!-- <button type="submit" class="btn btn&#45;primary" onClick="javascript: submitFunc()"> -->
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-arrow-right"></i> {{ strtoupper(trans('common.btn_apply')) }}
                </button>
                <button type="button" class="btn btn-default" onClick="javascript: cancelFunc();" style="margin-left: 10px;">
                    {{ strtoupper(trans('common.btn_cancel')) }}
                </button>
            </div>


    </form>
    <script type="text/javascript">

    var invalidDomains = ["@gmail.", "@yahoo.", "@hotmail.", "@live.", "@aol.", "@outlook."];

    function isValidEmail(email) {

        for (var i=0; i < invalidDomains.length; i++) {
            var domain = invalidDomains[i];
            if (email.indexOf(domain) != -1) {
                return false;
            }
        }

        return true;
    }

    function submitFunc() {

        var item = $('#email');
        if (item.val() != '' && !isValidEmail(item.val())) {
            alert("We suspended personal e-mail registration (like '@gmail', '@yahoo', '@hotmail', '@live', '@aol', '@outlook'), \nyou can use your company or business e-mail address to finish the registration processs.");
            item.focus();
            return;
        }

        document.getElementById('registerForm').submit();
    }  

    function cancelFunc(){
        document.location.replace("/user/");
    }

    </script>
</div>

@endsection
