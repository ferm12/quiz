class MacIds extends React.Component {

    constructor(props){
        super(props)
        this.fileInput = React.createRef();
        this.state = {
            macIds:[""],
            file:null,
            validMacIds:[false],
            newUser:false,
            validForm:false,
            solvedRecaptcha:false,
            enableSubmit:false,
            enableAddMacId:true
        }
        this.addMac             = this.addMac.bind(this);
        this.clearCSVFile       = this.clearCSVFile.bind(this);
        this.removeMac          = this.removeMac.bind(this);
        this.changeMac          = this.changeMac.bind(this);
        this.setEnableSubmit    = this.setEnableSubmit.bind(this);
        this.format             = this.format.bind(this);
        this.solvedRecaptcha    = this.solvedRecaptcha.bind(this);
        this.expiredRecaptcha   = this.expiredRecaptcha.bind(this);
        this.onSubmit           = this.onSubmit.bind(this);
        this.submitForm         = this.submitForm.bind(this);
        this.checkDBforMacIds   = this.checkDBforMacIds.bind(this);
        this.validateEmail      = this.validateEmail.bind(this);
        this.resetMacIds        = this.resetMacIds.bind(this);
    }

    componentDidMount(){
        //converting new_user to typeof boolean
        let new_user = Number(this.props.new_user);
        new_user = Boolean(new_user);
        if (new_user){
            this.setState({newUser:true});
        }
        if (this.state.macIds.length == 1){
            $("#mac-0 .remove-mac").hide();
        }else{
            $("#mac-0 .remove-mac").show();
        }
    }
    
    componentDidUpdate(){
        if (this.state.macIds.length == 1){
            $("#mac-0 .remove-mac").hide();
        }else{
            $("#mac-0 .remove-mac").show();
        }
    }

    addMac(){
        if (this.state.macIds.length < 4){
            this.setState({
                macIds: [...this.state.macIds, ""],
                validMacIds: [...this.state.validMacIds, false],
                enableSubmit:false,
                enableAddMacId:true
            });
        }else if(this.state.macIds.length == 4){
            this.setState({
                macIds: [...this.state.macIds, ""],
                validMacIds: [...this.state.validMacIds, false],
                enableSubmit:false,
                enableAddMacId:false
            });
        }   
        this.clearCSVFile()

    }

    format(input, format, sep) {
        /**
         * @param mix   input   mix alphanumeric
         * @param array format  array format
         * @param sep   string  char to used as seperator
         */
        var output = "";
        var idx = 0;
        for (var i = 0; i < format.length && idx < input.length; i++) {
            output += input.substr(idx, format[i]);
            if (idx + format[i] < input.length) output += sep;
                idx += format[i];
        }

        output += input.substr(idx);
        return output;
    }

    setEnableSubmit(){
        let found_invalid_mac = this.state.validMacIds.includes(false);
        let file = document.querySelector("#csv-file").files.length;
        let solvedRecaptcha = this.state.solvedRecaptcha;

        if ( (!found_invalid_mac || file) && solvedRecaptcha ){
            this.setState({enableSubmit: true });
        }else{
            this.setState({enableSubmit: false });
        }
    }
   
    changeMac(e, index){
        $('.input-mac').each(function(){
            $(this).attr('required', true);
            $(this).attr("minLength",17);
        });

        this.clearCSVFile();

        var alphanumeric = e.target.value.replace(/[^a-zA-Z0-9]/g, "");
        var formatted = this.format(alphanumeric,[2,2,2,2,2,2], ":");
        this.state.macIds[index] = formatted;

        this.setState({macIds: this.state.macIds})

        let mac_len = this.state.macIds[index].length;

        if (mac_len == 17) {
            console.log("mac_len:", mac_len);
            this.state.validMacIds[index] = true;
            this.setState({
                validMacIds: this.state.validMacIds
            }, () => {
                this.setEnableSubmit()
            });
        }
    }

    removeMac(index){
        console.log('this.state.macIds.length:',this.state.macIds.length );
        if (this.state.macIds.length > 1){
            this.state.macIds.splice(index,1);
            this.state.validMacIds.splice(index,1);
            this.setState({
                macIds: this.state.macIds,
                validMacIds: this.state.validMacIds,
                enableAddMacId:true,
            }, () => {
                // this.setEnableSubmit() 
            });
        }

        // this.setEnableSubmit();
    }

    solvedRecaptcha(){
        this.setState({ solvedRecaptcha:true }, () =>{
            this.setEnableSubmit();
        });
        console.log('user has solved the Recaptcha');
    }

    expiredRecaptcha(){
        this.setState({ solvedRecaptcha:false }, () =>{
            this.setEnableSubmit();
        });
        console.log('Recaptcha has expired'); 
    }

    submitForm(){

        let formData = new FormData();
        if (document.querySelector("#csv-file").files.length == 1){
            formData.append('csv_file', this.state.file);
        }            

        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            } 
        };
        formData.set('school_name', $("#school-name").val());
        formData.set('street_address', $("#street-address").val());
        formData.set('city', $("#city").val());
        formData.set('state', $("#state").val());
        formData.set('zip_code', $("#zip-code").val());
        formData.set('contact_name', $("#contact-name").val());
        formData.set('contact_email', $("#contact-email").val());
        formData.set('contact_phone', $("#contact-phone").val());
        formData.set('purchased_from', $("#purchased-from").val());
        formData.set('mac_ids', JSON.stringify(this.state.macIds));

        axios.post('/sbcc/form-submit.php', formData)
        .then((response)=>{
            console.log('ajax submitForm success:', response);
            window.location.replace("/sbcc/form-success.php");
        })
        .catch(function(error){
            console.log('error:', error); 
        });

    }

    validateEmail(email){
        let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        return re.test(email);
    }

    // reseting the MAC IDs inputs
    resetMacIds(){

        this.setState({
            macIds: [""],
            validMacIds: [false],
            enableAddMacId:true,
        }, () => {
                // this.setEnableSubmit() 
        });


        $('.input-mac').each(function(){
            $(this).attr('required', false);
            $(this).removeAttr("minLength");
        });
    }

    // this function checks that the input MAC IDs are valid, if not it prevents from submitting the form and displays a msg to the user with the list of failed MAC IDs
    checkDBforMacIds(){
        
        if (document.querySelector("#csv-file").files.length == 0){
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                } 
            };
            const formData = new FormData();
            formData.append('mac_ids', JSON.stringify(this.state.macIds));
            console.log("this.state.macIds:", this.state.macIds);

            axios.post('/sbcc/api/check-db-for-mac-ids.php', formData, config)
            .then((response)=>{
                console.log('success:', response.data); 
                let contact_email = $("#contact-email").val();

                if (response.data.valid_mac_ids.includes(false)){
                    let msg ="One or more of the MAC IDs you entered are invalid. Check your MAC IDs and try again. The following MAC IDs failed:\n";
                    for (let i = 0; i < response.data.valid_mac_ids.length; i++){
                        if(response.data.valid_mac_ids[i] == false) {
                            msg += response.data.mac_ids[i] +"\n";
                        }
                    }

                    alert(msg);

                }else if( !this.validateEmail(contact_email) ){

                    console.log("Invalid email");

                    alert("Invalid email");

                }else{

                    this.submitForm();

                }
            })
            .catch(function(error){
                console.log('error:', error); 
            });
           
        }else{
            this.resetMacIds();
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                } 
            };
            const formData = new FormData();
            formData.append('csv_file', this.state.file);

            axios.post('/sbcc/api/check-db-for-mac-ids.php', formData, config)
            .then((response)=>{
                console.log('success:', response.data); 
                if (response.data.valid_file){
                    this.submitForm();
                }else{
                    alert("Invalid file. Please make sure the file you are uploading was generated by the CMS and try again.");
                }
            })
            .catch(function(error){
                console.log('error:', error); 
            });
        }
    }

    onSubmit(e){
        e.preventDefault();
        console.log('you clicked on preventing submit');
        this.checkDBforMacIds();
    }

    clearCSVFile(){
        document.querySelector("#csv-file").value = "";
    }

    appendCSVFile(e){
        this.setState({
            file: e.target.files[0],
            // enableSubmit: true
        });
    }

    render() {
        return (
            <form id="sbcc-form" onSubmit={this.onSubmit}>
                <div className="form-group">
                    <label>School Name:</label>
                    <input type="text" name="school_name" className="form-control" id="school-name" defaultValue={this.props.school_name} required />
                </div>

                <div className="form-group">
                    <label>Street Address:</label>
                    <input type="text" className="form-control" id="street-address" defaultValue={this.props.street_address} required />
                </div>

                <div className="form-group">
                    <label>City:</label>
                    <input type="text" className="form-control" id="city" defaultValue={this.props.city} required />
                </div>

                <div className="form-group">
                    <label>State:</label>
                    <input type="text" className="form-control" id="state" defaultValue={this.props.state} required />
                </div>

                <div className="form-group">
                    <label>Zip Code:</label>
                    <input type="text" className="form-control" id="zip-code" defaultValue={this.props.zip_code} required />
                </div>

                <div className="form-group">
                    <label>Contact Name:</label>
                    <input type="text" className="form-control" id="contact-name" defaultValue={this.props.contact_name} required />
                </div>
                
                <div className="form-group">
                    <label>Contact email (Your activation key will be sent to this email):</label>
                    <input type="email" className="form-control" id="contact-email" defaultValue={this.props.contact_email} readOnly={this.state.newUser ? false : true} required />
                </div> 
                <div className="form-group">
                    <label>Contact Phone:</label>
                    <input type="text" className="form-control" id="contact-phone" defaultValue={this.props.contact_phone} required />
                </div>

                <div className="form-group">
                    <label>Company Purchased From:</label>
                    <input type="text" className="form-control" id="purchased-from" defaultValue={this.props.purchased_from} required />
                </div>

                <div id="mac-id-wrap">
                    <div id="mac-ids"> 
                        <label>MAC IDs (xx:xx:xx:xx:xx:xx):</label>
                        {
                            this.state.macIds.map((val, index)=>{
                                return (
                                    <div id={"mac-" + index} key={index}> 
                                        <input className="form-control input-mac" onChange={(e)=>this.changeMac(e, index)} value={val} maxLength="17" minLength="17" required />&nbsp;
                                        <img className="remove-mac" onClick={()=>this.removeMac(index)} src="/sbcc/img/red-x-mark.png" width="15" />
                                        <span className="msg"></span>
                                    </div>
                                ) 
                            }) 
                        } 
                        <button className="add-mac btn btn-info" type="button" onClick={(e)=>this.addMac()} disabled={!this.state.enableAddMacId ? 'disabled' : ''}>Add another MAC ID (up to 5)</button><span id="text-or">OR</span>

                        <label>Upload CSV file</label>

                        <input id="csv-file" name="csv_file" type="file" ref={this.fileInput} onClick={(e)=>this.resetMacIds()} onChange={(e)=>this.appendCSVFile(e) } accept=".csv" />   

                    </div>
                    <div id="sb-label">
                        <img src="/sbcc/img/sbwd1000-label.png" />
                    </div>
                </div>
                <Reaptcha sitekey="6LeRTVsUAAAAAPC8tk9gZODxLrpqvzC68vICTos_" onVerify={this.solvedRecaptcha} onExpire={this.expiredRecaptcha} />
                <br/><br/>
                <input type="submit" value="Submit" className="btn btn-primary" disabled={!this.state.enableSubmit ? 'disabled' : ''} />

            </form>
        )
    }
}

const new_user          = document.querySelector("#new-user-hidden").value;
const school_name       = document.querySelector("#school-name-hidden").value;
const street_address    = document.querySelector("#street-address-hidden").value;
const city              = document.querySelector("#city-hidden").value;
const state             = document.querySelector("#state-hidden").value;
const zip_code          = document.querySelector("#zip-code-hidden").value;
const contact_name      = document.querySelector("#contact-name-hidden").value;
const contact_email     = document.querySelector("#contact-email-hidden").value;
const contact_phone     = document.querySelector("#contact-phone-hidden").value;
const purchased_from    = document.querySelector("#purchased-from-hidden").value;

const domContainer = document.querySelector("#form");

ReactDOM.render( <MacIds 
        new_user        = {new_user}
        school_name     = {school_name}
        street_address  = {street_address}
        city            = {city}
        state           = {state}
        zip_code        = {zip_code}
        contact_name    = {contact_name}
        contact_email   = {contact_email}
        contact_phone   = {contact_phone}
        purchased_from  = {purchased_from}
        />,
        domContainer);
