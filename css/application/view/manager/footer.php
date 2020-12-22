
<?php
////session_start();
//$t=time();
//if (isset($_SESSION['logged']) && ($t - $_SESSION['logged'] > 60)) {
//    session_destroy();
//    session_unset();
//    header('location: index.php');
//}else {$_SESSION['logged'] = time();}
//
//?>


<script src="<?php echo URL; ?>assets/js/SIPml-api.js?svn=252" type="text/javascript"></script>
<style type="text/css">
    #spanCaret{
        display: none;
    }
    .normal-screen {
        position: relative;
    }
    .label-align {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
    }
    .input-align {
        width: 13px;
        height: 13px;
        padding: 0;
        margin: 0;
        vertical-align: bottom;
        position: relative;
        top: -1px;
        *overflow: hidden;
    }
    .glass-panel {
        z-index: 99;
        position: fixed;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        top: 0;
        left: 0;
        opacity: 0.8;
        /* background-color: Gray; */
    }
    .div-keypad {
        z-index: 100;
        position: fixed;
        -moz-transition-property: left top;
        -o-transition-property: left top;
        -webkit-transition-duration: 2s;
        -moz-transition-duration: 2s;
        -o-transition-duration: 2s;
    }
</style>

<script type="text/javascript">

    var sTransferNumber;
    var oRingTone, oRingbackTone;
    var oSipStack, oSipSessionRegister, oSipSessionCall, oSipSessionTransferCall;
    var videoRemote, videoLocal, audioRemote;
    var bFullScreen = false;
    var oNotifICall;
    var bDisableVideo = false;
    var viewVideoLocal, viewVideoRemote, viewLocalScreencast; // <video> (webrtc) or <div> (webrtc4all)
    var oConfigCall;
    var oReadyStateTimer;

    C =
        {
            divKeyPadWidth: 220
        };
    window.onload = function () {
        window.console && window.console.info && window.console.info("location=" + window.location);

        videoLocal = document.getElementById("video_local");
        videoRemote = document.getElementById("video_remote");
        audioRemote = document.getElementById("audio_remote");

        //document.onkeyup = onKeyUp;
        //document.body.onkeyup = onKeyUp;
        divCallCtrl.onmousemove = onDivCallCtrlMouseMove;

        // set debug level
        SIPml.setDebugLevel("error");

        // Initialize call button
        // uiBtnCallSetText("Ready");

        var getPVal = function (PName) {
            var query = window.location.search.substring(1);
            var vars = query.split('&');
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split('=');
                if (decodeURIComponent(pair[0]) === PName) {
                    return decodeURIComponent(pair[1]);
                }
            }
            return null;
        }

        var preInit = function () {
            // set default webrtc type (before initialization)
            var s_webrtc_type = getPVal("wt");
            var s_fps = getPVal("fps");
            var s_mvs = getPVal("mvs"); // maxVideoSize
            var s_mbwu = getPVal("mbwu"); // maxBandwidthUp (kbps)
            var s_mbwd = getPVal("mbwd"); // maxBandwidthUp (kbps)
            var s_za = getPVal("za"); // ZeroArtifacts
            var s_ndb = getPVal("ndb"); // NativeDebug

            if (s_webrtc_type) SIPml.setWebRtcType(s_webrtc_type);

            // initialize SIPML5
            SIPml.init(postInit);

            // set other options after initialization
            if (s_fps) SIPml.setFps(parseFloat(s_fps));
            if (s_mvs) SIPml.setMaxVideoSize(s_mvs);
            if (s_mbwu) SIPml.setMaxBandwidthUp(parseFloat(s_mbwu));
            if (s_mbwd) SIPml.setMaxBandwidthDown(parseFloat(s_mbwd));
            if (s_za) SIPml.setZeroArtifacts(s_za === "true");
            if (s_ndb == "true") SIPml.startNativeDebug();

        }

        oReadyStateTimer = setInterval(function () {
                if (document.readyState === "complete") {
                    clearInterval(oReadyStateTimer);
                    // initialize SIPML5
                    preInit();
                }
            },
            500);
    };

    function postInit() {
        // check for WebRTC support
        if (!SIPml.isWebRtcSupported()) {
            // is it chrome?
            if (SIPml.getNavigatorFriendlyName() == 'chrome') {
                if (confirm("You're using an old Chrome version or WebRTC is not enabled.\nDo you want to see how to enable WebRTC?")) {
                    window.location = 'http://www.webrtc.org/running-the-demos';
                }
                else {
                    window.location = "index.html";
                }
                return;
            }
            else {
                if (confirm("webrtc-everywhere extension is not installed. Do you want to install it?\nIMPORTANT: You must restart your browser after the installation.")) {
                    window.location = 'https://github.com/sarandogou/webrtc-everywhere';
                }
                else {
                    // Must do nothing: give the user the chance to accept the extension
                    // window.location = "index.html";
                }
            }
        }

        // checks for WebSocket support
        if (!SIPml.isWebSocketSupported()) {
            if (confirm('Your browser don\'t support WebSockets.\nDo you want to download a WebSocket-capable browser?')) {
                window.location = 'https://www.google.com/intl/en/chrome/browser/';
            }
            else {
                window.location = "index.html";
            }
            return;
        }

        // FIXME: displays must be per session
        viewVideoLocal = videoLocal;
        viewVideoRemote = videoRemote;

        if (!SIPml.isWebRtcSupported()) {
            if (confirm('Your browser don\'t support WebRTC.\naudio/video calls will be disabled.\nDo you want to download a WebRTC-capable browser?')) {
                window.location = 'https://www.google.com/intl/en/chrome/browser/';
            }
        }

        //btnRegister.disabled = false;
        document.body.style.cursor = 'default';
        oConfigCall = {
            audio_remote: audioRemote,
            video_local: viewVideoLocal,
            video_remote: viewVideoRemote,
            screencast_window_id: 0x00000000, // entire desktop
            bandwidth: { audio: undefined, video: undefined },
            video_size: { minWidth: undefined, minHeight: undefined, maxWidth: undefined, maxHeight: undefined },
            events_listener: { events: '*', listener: onSipEventSession },
            sip_caps: [
                { name: '+g.oma.sip-im' },
                { name: 'language', value: '\"en,fr\"' }
            ]
        };
    }


    // sends SIP REGISTER request to login
    function sipRegister() {
        // catch exception for IE (DOM not ready)
        try {
            // enable notifications if not already done
            if (window.webkitNotifications && window.webkitNotifications.checkPermission() != 0) {
                window.webkitNotifications.requestPermission();
            }
            // update debug level to be sure new values will be used if the user haven't updated the page
            SIPml.setDebugLevel("error");//"error" : "info"

            txtDisplayName = "<?=$_SESSION['user_sip'];?>";
            txtPrivateIdentity = "<?=$_SESSION['user_sip'];?>";
            txtPublicIdentity = "sip:<?=$_SESSION['user_sip'];?>@<?=SIP_SERVER?>";
            txtPassword = "<?=$_SESSION['user_sip'];?>";
            txtRealm = "<?=SIP_SERVER?>";
            txtWebsocket_proxy_url="ws://<?=SIP_SERVER?>:8088/ws";

            // create SIP stack
            oSipStack = new SIPml.Stack({
                    realm: txtRealm,
                    impi: txtPrivateIdentity,
                    impu: txtPublicIdentity,
                    password: txtPassword,
                    display_name: txtDisplayName,
                    websocket_proxy_url:txtWebsocket_proxy_url,
                    outbound_proxy_url: null,
                    ice_servers: [{"url":"stun:stun.l.google.com:19302"}],
                    enable_rtcweb_breaker: false,
                    events_listener: { events: '*', listener: onSipEventStack },
                    enable_early_ims: false, // Must be true unless you're using a real IMS network
                    enable_media_stream_cache: false,
                    bandwidth: null, // could be redefined a session-level
                    video_size:null, // could be redefined a session-level
                    sip_headers: [
                        { name: 'User-Agent', value: 'IM-client/OMA1.0 sipML5-v1.2016.03.04' },
                        { name: 'Organization', value: 'Any1Coin' }
                    ]
                }
            );
            if (oSipStack.start() != 0) {
                txtRegStatus.innerHTML = '<b>Failed to start the SIP stack</b>';
            }
            else return;
        }
        catch (e) {
            txtRegStatus.innerHTML = "<b>2:" + e + "</b>";
        }
    }

    // sends SIP REGISTER (expires=0) to logout
    function sipUnRegister() {
        $('.call_now_btn').hide();
        if (oSipStack) {
            oSipStack.stop(); // shutdown all sessions
        }
    }

    // makes a call (SIP INVITE)
    function sipCall(s_type,phone_number,lead_id) {
        if (oSipStack && !oSipSessionCall && !tsk_string_is_null_or_empty(phone_number)) {
            if (s_type == 'call-screenshare') {
                if (!SIPml.isScreenShareSupported()) {
                    alert('Screen sharing not supported. Are you using chrome 26+?');
                    return;
                }
                if (!location.protocol.match('https')) {
                    if (confirm("Screen sharing requires https://. Do you want to be redirected?")) {
                        sipUnRegister();
                        //window.location = 'https://ns313841.ovh.net/call.htm';
                    }
                    return;
                }
            }
            btnCall.disabled = true;
            btnHangUp.disabled = false;

            if (window.localStorage) {
                oConfigCall.bandwidth = tsk_string_to_object(window.localStorage.getItem('org.doubango.expert.bandwidth')); // already defined at stack-level but redifined to use latest values
                oConfigCall.video_size = tsk_string_to_object(window.localStorage.getItem('org.doubango.expert.video_size')); // already defined at stack-level but redifined to use latest values
            }

            // create call session
            oSipSessionCall = oSipStack.newSession(s_type, oConfigCall);
            // make call
            if (oSipSessionCall.call(phone_number) != 0) {
                oSipSessionCall = null;
                txtCallStatus.value = 'Failed to make call';
                btnCall.disabled = false;
                btnHangUp.disabled = true;
                return;
            }

        }
        else if (oSipSessionCall) {
            txtCallStatus.innerHTML = '<i>Connecting...</i>';
            oSipSessionCall.accept(oConfigCall);
        }
        ///log calls
        $.ajax({
            url: '<?=URL?>api/logCall/out',
            type: 'POST',
            data:{phone_number:lead_id}
        }).done(function(data) {
            //console.log(data);
        });
    }

    // transfers the call
    function sipTransfer() {
        if (oSipSessionCall) {
            var s_destination = prompt('Enter destination number', '');
            if (!tsk_string_is_null_or_empty(s_destination)) {
                btnTransfer.disabled = true;
                if (oSipSessionCall.transfer(s_destination) != 0) {
                    txtCallStatus.innerHTML = '<i>Call transfer failed</i>';
                    btnTransfer.disabled = false;
                    return;
                }
                txtCallStatus.innerHTML = '<i>Transfering the call...</i>';
            }
        }
    }

    // holds or resumes the call
    function sipToggleHoldResume() {
        if (oSipSessionCall) {
            var i_ret;
            btnHoldResume.disabled = true;
            txtCallStatus.innerHTML = oSipSessionCall.bHeld ? '<i>Resuming the call...</i>' : '<i>Holding the call...</i>';
            i_ret = oSipSessionCall.bHeld ? oSipSessionCall.resume() : oSipSessionCall.hold();
            if (i_ret != 0) {
                txtCallStatus.innerHTML = '<i>Hold / Resume failed</i>';
                btnHoldResume.disabled = false;
                return;
            }
        }
    }

    // Mute or Unmute the call
    function sipToggleMute() {
        if (oSipSessionCall) {
            var i_ret;
            var bMute = !oSipSessionCall.bMute;
            txtCallStatus.innerHTML = bMute ? '<i>Mute the call...</i>' : '<i>Unmute the call...</i>';
            i_ret = oSipSessionCall.mute('audio'/*could be 'video'*/, bMute);
            if (i_ret != 0) {
                txtCallStatus.innerHTML = '<i>Mute / Unmute failed</i>';
                return;
            }
            oSipSessionCall.bMute = bMute;
            btnMute.value = bMute ? "Unmute" : "Mute";
        }
    }

    // terminates the call (SIP BYE or CANCEL)
    function sipHangUp() {
        if (oSipSessionCall) {
            txtCallStatus.innerHTML = '<i>Terminating the call...</i>';
            oSipSessionCall.hangup({ events_listener: { events: '*', listener: onSipEventSession } });
        }
    }

    function sipSendDTMF(c) {
        if (oSipSessionCall && c) {
            if (oSipSessionCall.dtmf(c) == 0) {
                try { dtmfTone.play(); } catch (e) { }
            }
        }
    }

    function startRingTone() {
        try { ringtone.play(); }
        catch (e) { }
    }

    function stopRingTone() {
        try { ringtone.pause(); }
        catch (e) { }
    }

    function startRingbackTone() {
        try { ringbacktone.play(); }
        catch (e) { }
    }

    function stopRingbackTone() {
        try { ringbacktone.pause(); }
        catch (e) { }
    }

    function callEndRingtone() {
        try { callend.play(); }
        catch (e) { console.log(e); }
    }

    function openKeyPad() {
        divKeyPad.style.visibility = 'visible';
        divKeyPad.style.left = ((document.body.clientWidth - C.divKeyPadWidth) >> 1) + 'px';
        divKeyPad.style.top = '70px';
        divGlassPanel.style.visibility = 'visible';
    }

    function closeKeyPad() {
        divKeyPad.style.left = '0px';
        divKeyPad.style.top = '0px';
        divKeyPad.style.visibility = 'hidden';
        divGlassPanel.style.visibility = 'hidden';
    }

    function showNotifICall(s_number) {
        // permission already asked when we registered
        if (window.webkitNotifications && window.webkitNotifications.checkPermission() == 0) {
            if (oNotifICall) {
                oNotifICall.cancel();
            }
            oNotifICall = window.webkitNotifications.createNotification('images/sipml-34x39.png', 'Incoming call', 'Incoming call from ' + s_number);
            oNotifICall.onclose = function () { oNotifICall = null; };
            oNotifICall.show();
        }
    }


    function onDivCallCtrlMouseMove(evt) {
        try { // IE: DOM not ready
            if (tsk_utils_have_stream()) {
                btnCall.disabled = (!tsk_utils_have_stream() || !oSipSessionRegister || !oSipSessionRegister.is_connected());
                document.getElementById("divCallCtrl").onmousemove = null; // unsubscribe
            }
        }
        catch (e) { }
    }

    function uiOnConnectionEvent(b_connected, b_connecting) { // should be enum: connecting, connected, terminating, terminated
        //btnRegister.disabled = b_connected || b_connecting;
        //btnUnRegister.disabled = !b_connected && !b_connecting;
        $('.call_now_btn').show();
        btnCall.disabled = !(b_connected && tsk_utils_have_webrtc() && tsk_utils_have_stream());
        btnHangUp.disabled = !oSipSessionCall;
    }


    function uiDisableCallOptions() {
        if (window.localStorage) {
            window.localStorage.setItem('org.doubango.expert.disable_callbtn_options', 'true');
            // uiBtnCallSetText('Ready');
            alert('Use expert view to enable the options again (/!\\requires re-loading the page)');
        }
    }

    function uiBtnCallSetText(s_text) {
        switch (s_text) {
            case "Ready":
            {
                var bDisableCallBtnOptions = (window.localStorage && window.localStorage.getItem('org.doubango.expert.disable_callbtn_options') == "true");
                // btnCall.value = btnCall.innerHTML = bDisableCallBtnOptions ? 'Ready' : 'Ready <span id="spanCaret" class="caret">';
                // btnCall.setAttribute("class", bDisableCallBtnOptions ? "btn btn-primary" : "btn btn-primary dropdown-toggle");
                btnCall.onclick = bDisableCallBtnOptions ? function () { sipCall(bDisableVideo ? 'call-audio' : 'call-audiovideo'); } : null;
                ulCallOptions.style.visibility = bDisableCallBtnOptions ? "hidden" : "visible";
                if (!bDisableCallBtnOptions && ulCallOptions.parentNode != divBtnCallGroup) {
                    divBtnCallGroup.appendChild(ulCallOptions);
                }
                else if (bDisableCallBtnOptions && ulCallOptions.parentNode == divBtnCallGroup) {
                    document.body.appendChild(ulCallOptions);
                }

                break;
            }
            default:
            {
                // btnCall.value = btnCall.innerHTML = s_text;
                // btnCall.setAttribute("class", "btn btn-primary");
                btnCall.onclick = function () { sipCall(bDisableVideo ? 'call-audio' : 'call-audiovideo'); };
                ulCallOptions.style.visibility = "hidden";
                if (ulCallOptions.parentNode == divBtnCallGroup) {
                    document.body.appendChild(ulCallOptions);
                }
                break;
            }
        }
    }

    function uiCallTerminated(s_description) {
        uiBtnCallSetText("");
        btnHangUp.value = 'HangUp';
        btnHoldResume.value = 'hold';
        btnMute.value = "Mute";
        btnCall.disabled = false;
        btnHangUp.disabled = true;
        if (window.btnBFCP) window.btnBFCP.disabled = true;

        oSipSessionCall = null;

        stopRingbackTone();
        stopRingTone();

        txtCallStatus.innerHTML = "<i>" + s_description + "</i>";

        divCallOptions.style.display = "none";

        if (oNotifICall) {
            oNotifICall.cancel();
            oNotifICall = null;
        }

        setTimeout(function () { if (!oSipSessionCall) txtCallStatus.innerHTML = ''; }, 2500);
    }

    // Callback function for SIP Stacks
    function onSipEventStack(e /*SIPml.Stack.Event*/) {
        tsk_utils_log_info('==stack event = ' + e.type);
        switch (e.type) {
            case 'started':
            {
                // catch exception for IE (DOM not ready)
                try {
                    // LogIn (REGISTER) as soon as the stack finish starting
                    oSipSessionRegister = this.newSession('register', {
                        expires: 200,
                        events_listener: { events: '*', listener: onSipEventSession },
                        sip_caps: [
                            { name: '+g.oma.sip-im', value: null },
                            //{ name: '+sip.ice' }, // rfc5768: FIXME doesn't work with Polycom TelePresence
                            { name: '+audio', value: null },
                            { name: 'language', value: '\"en,fr\"' }
                        ]
                    });
                    oSipSessionRegister.register();
                }
                catch (e) {
                    txtRegStatus.value = txtRegStatus.innerHTML = "<b>1:" + e + "</b>";
                }
                break;
            }
            case 'stopping': case 'stopped': case 'failed_to_start': case 'failed_to_stop':
            {
                var bFailure = (e.type == 'failed_to_start') || (e.type == 'failed_to_stop');
                oSipStack = null;
                oSipSessionRegister = null;
                oSipSessionCall = null;

                uiOnConnectionEvent(false, false);

                stopRingbackTone();
                stopRingTone();


                divCallOptions.style.display = 'none';

                txtCallStatus.innerHTML = '';
                txtRegStatus.innerHTML = bFailure ? "<i>Disconnected: <b>" + e.description + "</b></i>" : "<i>Disconnected</i>";
                break;
            }

            case 'i_new_call':
            {
                if (oSipSessionCall) {
                    // do not accept the incoming call if we're already 'in call'
                    e.newSession.hangup(); // comment this line for multi-line support
                }
                else {
                    oSipSessionCall = e.newSession;
                    // start listening for events
                    oSipSessionCall.setConfiguration(oConfigCall);

                    uiBtnCallSetText('Answer');
                    btnHangUp.value = 'Reject';
                    btnCall.disabled = false;
                    btnHangUp.disabled = false;

                    startRingTone();

                    var sRemoteNumber = (oSipSessionCall.getRemoteFriendlyName() || 'unknown');

                    ///log calls
                    $.ajax({
                        url: '<?=URL?>api/logCall/in',
                        type: 'POST',
                        data:{phone_number:sRemoteNumber}
                    }).done(function(data) {
                        console.log(data);
                        sRemoteNumber=data;
                        txtCallStatus.innerHTML = "<i>Incoming call from [<b>" + sRemoteNumber + "</b>]</i>";
                        showNotifICall(sRemoteNumber);
                    });
                }
                break;
            }

            case 'm_permission_requested':
            {
                divGlassPanel.style.visibility = 'visible';
                break;
            }
            case 'm_permission_accepted':
            case 'm_permission_refused':
            {
                divGlassPanel.style.visibility = 'hidden';
                if (e.type == 'm_permission_refused') {
                    uiCallTerminated('Media stream permission denied');
                }
                break;
            }

            case 'starting': default: break;
        }
    };

    // Callback function for SIP sessions (INVITE, REGISTER, MESSAGE...)
    function onSipEventSession(e /* SIPml.Session.Event */) {
        tsk_utils_log_info('==session event = ' + e.type);

        switch (e.type) {
            case 'connecting': case 'connected':
            {
                var bConnected = (e.type == 'connected');
                if (e.session == oSipSessionRegister) {
                    uiOnConnectionEvent(bConnected, !bConnected);
                    txtRegStatus.innerHTML = "<i>" + e.description + "</i>";


                }
                else if (e.session == oSipSessionCall) {
                    btnHangUp.value = 'HangUp';
                    btnCall.disabled = true;
                    btnHangUp.disabled = false;
                    btnTransfer.disabled = false;


                    if (window.btnBFCP) window.btnBFCP.disabled = false;

                    if (bConnected) {
                        stopRingbackTone();
                        stopRingTone();

                        if (oNotifICall) {
                            oNotifICall.cancel();
                            oNotifICall = null;
                        }
                    }

                    txtCallStatus.innerHTML = "<i>" + e.description + "</i>";
                    divCallOptions.style.display = bConnected ? 'flex' : 'none';

                    if (SIPml.isWebRtc4AllSupported()) { // IE don't provide stream callback

                    }
                }
                break;
            } // 'connecting' | 'connected'
            case 'terminating': case 'terminated':
            {
                if (e.session == oSipSessionRegister) {
                    uiOnConnectionEvent(false, false);

                    oSipSessionCall = null;
                    oSipSessionRegister = null;
                    console.log('call terminated 1');

                    callEndRingtone();


                    txtRegStatus.innerHTML = "<i>" + e.description + "</i>";
                }
                else if (e.session == oSipSessionCall) {
                    uiCallTerminated(e.description);
                    console.log('call terminated 2');

                    callEndRingtone();

                }
                break;
            } // 'terminating' | 'terminated'

            case 'i_ect_new_call':
            {
                oSipSessionTransferCall = e.session;
                break;
            }

            case 'i_ao_request':
            {
                if (e.session == oSipSessionCall) {
                    var iSipResponseCode = e.getSipResponseCode();
                    if (iSipResponseCode == 180 || iSipResponseCode == 183) {
                        startRingbackTone();
                        txtCallStatus.innerHTML = '<i>Ringing...</i>';
                    }
                }
                break;
            }

            case 'm_early_media':
            {
                if (e.session == oSipSessionCall) {
                    stopRingbackTone();
                    stopRingTone();
                    txtCallStatus.innerHTML = '<i>Early media started</i>';
                }
                break;
            }

            case 'm_local_hold_ok':
            {
                if (e.session == oSipSessionCall) {
                    if (oSipSessionCall.bTransfering) {
                        oSipSessionCall.bTransfering = false;
                        // this.AVSession.TransferCall(this.transferUri);
                    }
                    btnHoldResume.value = 'Resume';
                    btnHoldResume.disabled = false;
                    txtCallStatus.innerHTML = '<i>Call placed on hold</i>';
                    oSipSessionCall.bHeld = true;
                }
                break;
            }
            case 'm_local_hold_nok':
            {
                if (e.session == oSipSessionCall) {
                    oSipSessionCall.bTransfering = false;
                    btnHoldResume.value = 'Hold';
                    btnHoldResume.disabled = false;
                    txtCallStatus.innerHTML = '<i>Failed to place remote party on hold</i>';
                }
                break;
            }
            case 'm_local_resume_ok':
            {
                if (e.session == oSipSessionCall) {
                    oSipSessionCall.bTransfering = false;
                    btnHoldResume.value = 'Hold';
                    btnHoldResume.disabled = false;
                    txtCallStatus.innerHTML = '<i>Call taken off hold</i>';
                    oSipSessionCall.bHeld = false;

                    if (SIPml.isWebRtc4AllSupported()) { // IE don't provide stream callback yet
                        //uiVideoDisplayEvent(false, true);
                        //uiVideoDisplayEvent(true, true);
                    }
                }
                break;
            }
            case 'm_local_resume_nok':
            {
                if (e.session == oSipSessionCall) {
                    oSipSessionCall.bTransfering = false;
                    btnHoldResume.disabled = false;
                    txtCallStatus.innerHTML = '<i>Failed to unhold call</i>';
                }
                break;
            }
            case 'm_remote_hold':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = '<i>Placed on hold by remote party</i>';
                }
                break;
            }
            case 'm_remote_resume':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = '<i>Taken off hold by remote party</i>';
                }
                break;
            }
            case 'm_bfcp_info':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = 'BFCP Info: <i>' + e.description + '</i>';
                }
                break;
            }

            case 'o_ect_trying':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = '<i>Call transfer in progress...</i>';
                }
                break;
            }
            case 'o_ect_accepted':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = '<i>Call transfer accepted</i>';
                }
                break;
            }
            case 'o_ect_completed':
            case 'i_ect_completed':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = '<i>Call transfer completed</i>';
                    btnTransfer.disabled = false;
                    if (oSipSessionTransferCall) {
                        oSipSessionCall = oSipSessionTransferCall;
                    }
                    oSipSessionTransferCall = null;
                }
                break;
            }
            case 'o_ect_failed':
            case 'i_ect_failed':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = '<i>Call transfer failed</i>';
                    btnTransfer.disabled = false;
                }
                break;
            }
            case 'o_ect_notify':
            case 'i_ect_notify':
            {
                if (e.session == oSipSessionCall) {
                    txtCallStatus.innerHTML = "<i>Call Transfer: <b>" + e.getSipResponseCode() + " " + e.description + "</b></i>";
                    if (e.getSipResponseCode() >= 300) {
                        if (oSipSessionCall.bHeld) {
                            oSipSessionCall.resume();
                        }
                        btnTransfer.disabled = false;
                    }
                }
                break;
            }
            case 'i_ect_requested':
            {
                if (e.session == oSipSessionCall) {
                    var s_message = "Do you accept call transfer to [" + e.getTransferDestinationFriendlyName() + "]?";//FIXME
                    if (confirm(s_message)) {
                        txtCallStatus.innerHTML = "<i>Call transfer in progress...</i>";
                        oSipSessionCall.acceptTransfer();
                        break;
                    }
                    oSipSessionCall.rejectTransfer();
                }
                break;
            }
        }
    }

</script>
<div class="softphone ">

    <div id="divCallCtrl" class="span7 " style=''>

        <table style='width: 80%;'>
            <tr>
                <td colspan="1" align="right">

                    <object id="fakePluginInstance" classid="clsid:69E4A9D1-824C-40DA-9680-C7424A27B6A0" style="visibility:hidden;"> </object>

                    <!-- /container -->
                    <!-- Glass Panel -->
                    <div id='divGlassPanel' class='glass-panel' style='visibility:hidden'></div>
                    <!-- KeyPad Div -->
                    <div id='divKeyPad' class='span2 well div-keypad' style="left:0px; top:0px; width:250; height:240; visibility:hidden">
                        <table style="width: 100%; height: 100%">
                            <tr><td><input type="button" style="width: 33%" class="btn" value="1" onclick="sipSendDTMF('1');" /><input type="button" style="width: 33%" class="btn" value="2" onclick="sipSendDTMF('2');" /><input type="button" style="width: 33%" class="btn" value="3" onclick="sipSendDTMF('3');" /></td></tr>
                            <tr><td><input type="button" style="width: 33%" class="btn" value="4" onclick="sipSendDTMF('4');" /><input type="button" style="width: 33%" class="btn" value="5" onclick="sipSendDTMF('5');" /><input type="button" style="width: 33%" class="btn" value="6" onclick="sipSendDTMF('6');" /></td></tr>
                            <tr><td><input type="button" style="width: 33%" class="btn" value="7" onclick="sipSendDTMF('7');" /><input type="button" style="width: 33%" class="btn" value="8" onclick="sipSendDTMF('8');" /><input type="button" style="width: 33%" class="btn" value="9" onclick="sipSendDTMF('9');" /></td></tr>
                            <tr><td><input type="button" style="width: 33%" class="btn" value="*" onclick="sipSendDTMF('*');" /><input type="button" style="width: 33%" class="btn" value="0" onclick="sipSendDTMF('0');" /><input type="button" style="width: 33%" class="btn" value="#" onclick="sipSendDTMF('#');" /></td></tr>
                            <tr><td colspan=3><input type="button" style="width: 100%" class="btn btn-medium btn-danger" value="close" onclick="closeKeyPad();" /></td></tr>
                        </table>
                    </div>
                    <!-- Call button options -->
                    <ul id="ulCallOptions" class="dropdown-menu" style="visibility:hidden">
                        <li><a href="#" onclick='sipCall("call-audio",phone_number);'>Audio</a></li>
                        <li><a href="#" onclick='sipCall("call-audiovideo");'>Video</a></li>
                        <li class="divider"></li>
                        <li><a href="#" onclick='uiDisableCallOptions();'><b>Disable these options</b></a></li>
                    </ul>

                    <!-- Audios -->
                    <audio id="audio_remote" autoplay="autoplay"> </audio>
                    <audio id="ringtone" loop src="<?php echo URL; ?>assets/sounds/ringtone.wav"> </audio>
                    <audio id="ringbacktone" loop src="<?php echo URL; ?>assets/sounds/ringbacktone.wav"> </audio>
                    <audio id="dtmfTone" src="<?php echo URL; ?>assets/sounds/dtmf.wav"> </audio>
                    <audio id="callend" src="<?php echo URL; ?>assets/sounds/beep.wav"> </audio>
                    <script>
                        jQuery(document).ready(function($) {
                            console.log('registering.........');
                            setTimeout(sipRegister, 1000);

                        });
                    </script>
    </div>
</div>
<!--
            <footer class="footer">

                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a style="margin-right:15px" href="#">mING</a>
                    </p>
                </div>
            </footer> -->
</div>
</div>
<script type="text/javascript">
    var softFooter=$('.softphone').width();
    var currentWidth=$('.main-panel').width();
    console.log('current'+currentWidth);
    function sidebar_toggle(){
        if ($('.main-panel').width()==currentWidth) {
            console.log('if'+currentWidth);
            $('.main-panel').css('width','100%')
            $('.softphone').css({'width':'calc(98%)','left':'1%'});
        }else{
            $('.main-panel').css('width',currentWidth);
            $('.softphone').css({'left':'275px', 'width':softFooter});



            console.log('else'+currentWidth);
        }
    }

    $( ".fbtn" ).click(function() {
        $('.sidebar').toggle(300);
        sidebar_toggle(currentWidth);
    });


    document.addEventListener('DOMContentLoaded', function () {
        if (!Notification) {
            alert('Desktop notifications not available in your browser. Try Chromium.');
            return;
        }
        if (Notification.permission !== "granted")
            Notification.requestPermission();
    });
    function notify(task) {
        var audio = new Audio('<?php echo URL; ?>assets/beep.ogg');
        audio.play();
        var turl="<?=URL.$_SESSION['role']?>/viewLead/"+task.lead_id+"?modal="+task.task_id;
        console.log(turl);
        pop(turl);
        var notification = new Notification('You have a meeting now', {
            icon: '<?php echo URL; ?>assets/img/meet.ico',
            body: task.title
        });
        notification.onclick = function () {
            var turl="<?=URL.$_SESSION['role']?>/viewLead/"+task.lead_id+"?modal="+task.task_id;
            console.log(turl);
            pop(turl);
        };
    }

    function notifyEvent(event) {
        var audio = new Audio('<?php echo URL; ?>assets/beep.ogg');
        audio.play();
        var turl="<?=URL.$_SESSION['role']?>/viewLead/"+event.lead_id+"?modal="+event.event_id;
        console.log(turl);
        pop(turl);
        var notification = new Notification('You have a meeting now', {
            icon: '<?php echo URL; ?>assets/img/meet.ico',
            body: event.title
        });
        notification.onclick = function () {
            var turl="<?=URL.$_SESSION['role']?>/viewLead/"+event.lead_id+"?modal="+event.task_id;
            console.log(turl);
            pop(turl);
        };
    }

    function notifyReminder(reminder) {
        var audio = new Audio('<?php echo URL; ?>assets/beep.ogg');
        audio.play();
        var turl="<?=URL.$_SESSION['role']?>/viewLead/"+reminder.lead_id+"?modal="+reminder.reminder_id;
        console.log(turl);
        pop(turl);
        var notification = new Notification('You have a meeting now', {
            icon: '<?php echo URL; ?>assets/img/meet.ico',
            body: reminder.title
        });
        notification.onclick = function () {
            var turl="<?=URL.$_SESSION['role']?>/viewLead/"+reminder.lead_id+"?modal="+reminder.task_id;
            console.log(turl);
            pop(turl);
        };
    }

    function pop(turl){
        var windowSize = {
            width: 500,
            height: 300,
        };
        var windowLocation = {
            left:  (window.screen.availLeft + (window.screen.availWidth )) - (windowSize.width ),
            top: (window.screen.availTop + (window.screen.availHeight )) - (windowSize.height )
        };
        window.open(turl, 'lead'+Date.now(), 'width=' + windowSize.width + ', height=' + windowSize.height + ', left=' + windowLocation.left + ', top=' + windowLocation.top);
    }

    function getNotifications(){
        $.ajax({
            url: '<?=URL?>api/notifications',
            type: 'post',
            dataType:"json",
            success: function(data){
                $.each(data, function(i, item) {
                    notify(data[i]);
                });
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
                setTimeout(getNotifications,5000);
            }
        });
    }


    function getNotificationsEvents(){
        $.ajax({
            url: '<?=URL?>api/notificationsEvents',
            type: 'post',
            dataType:"json",
            success: function(data){
                $.each(data, function(i, item) {
                    notifyEvent(data[i]);
                });
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
                setTimeout(getNotificationsEvents,7000);
            }
        });
    }

    function getNotificationsReminders(){
        $.ajax({
            url: '<?=URL?>api/notificationsReminders',
            type: 'post',
            dataType:"json",
            success: function(data){
                $.each(data, function(i, item) {
                    notifyReminder(data[i]);
                });
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
                setTimeout(getNotificationsReminders,9000);
            }
        });
    }


    function setTaskStatus(task_id){
        $.ajax({
            url: '<?=URL?>api/setTaskStatus/'+task_id,
            type: 'get',
            success: function(data){
                $('#task_'+task_id).html('Completed');
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
            }
        });
    }

    function setEventStatus(event_id){
        $.ajax({
            url: '<?=URL?>api/setEventStatus/'+event_id,
            type: 'get',
            success: function(data){
                $('#event_'+event_id).html('Completed');
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
            }
        });
    }

    function setReminderStatus(event_id){
        $.ajax({
            url: '<?=URL?>api/setReminderStatus/'+event_id,
            type: 'get',
            success: function(data){
                $('#reminder_'+event_id).html('Completed');
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
            }
        });
    }

    function countLeads(){
        $.ajax({
            url: '<?=URL?>api/countLeads/',
            type: 'get',
            dataType:'json',
            success: function(data){
                if (data.count){
                    $('.leadscount').remove();
                    $('.leadsNav >a >p').append('<font class="pull-right active leadscount">'+data.count+'</font>');
                }
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
            }
        });
    }

    function countNewLeads(){
        $.ajax({
            url: '<?=URL?>api/countNewLeads/',
            type: 'get',
            dataType:'json',
            success: function(data){
                if (data.count) {
                    if (data.count>0) {
                        $('.newleadscount').remove();
                        $('.leadsNav >a >p').append('<ul class="pagination pull-right newleadscount" style="margin:0;"><li class="page-item active"><a class="page-link" style="color:white;background-image: radial-gradient( circle farthest-corner at 10% 20%, #F44336 0%, rgba(64,64,64,1) 90.2% );">'+data.count+'</a></li></ul>');
                    }else {
                        $('.newleadscount').remove();
                    }
                }
            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
            }
        });
    }

    function resetNewLeads(){
        $.ajax({
            url: '<?=URL?>api/resetNewLeads/',
            type: 'get',
            dataType:'json',
            success: function(data){

            },
            fail: function(data){
                console.log("error");
            },
            complete:function(data){
            }
        });
    }


    countNewLeads();
    setInterval(function(){
        countLeads();
    }, 30000);

    setInterval(function(){
        countNewLeads();
    }, 20000);
    function sleep(delay) {
        var start = new Date().getTime();
        while (new Date().getTime() < start + delay);
    }
    $(".cho").chosen();
    function shakescreen(n)
    {
        if (parent.moveBy)
        {
            for (i = 10; i > 0; i--)
            {
                for (j = n; j > 0; j--)
                {
                    parent.moveBy(0, i);
                    parent.moveBy(i, 0);
                    parent.moveBy(0, -i);
                    parent.moveBy(-i, 0);
                }
            }
        }
    }


</script>
<?php if (isset($_GET['modal'])): ?>
    <style media="screen">
        .sidebar{display:none !important}
        .main-panel{width: 100% !important}
        .modal_<?=$_GET['modal']?>{border-color: red !important}
    </style>
    <script type="text/javascript">
        shakescreen(10);
    </script>
<?php endif; ?>
<?php if (!isset($_GET['modal'])): ?>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(getNotifications,5000);
            setTimeout(getNotificationsEvents,7000);
            setTimeout(getNotificationsReminders,9000);
        });
    </script>
<?php endif; ?>



<div id="manual_call" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px">
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">Phone number</label>
                        <input type="text" id='manual_call_number' name="phone_number_manual" class="form-control">
                    </div>
                    <center>
                        <a>
                            <i style="cursor:pointer;" title="Mobile" data-title="Mobile"  onclick="sipCall('call-audio','<?='77'.$_SESSION['user_sip'];?>'+$('#manual_call_number').val(),$('#manual_call_number').val(),$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn">call</i>
                        </a>
                        &nbsp;
                        <a>
                            <i style="cursor:pointer;"  title="Office" data-title="Office" onclick="sipCall('call-audio','<?=$_SESSION['user_sip'];?>'+$('#manual_call_number').val(),$('#manual_call_number').val(),$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn">call</i>
                        </a>
                        &nbsp;
                        <a>
                            <i style="cursor:pointer;" title="Random IT" data-title="Random IT" onclick="sipCall('call-audio','<?='99';?>'+$('#manual_call_number').val(),$('#manual_call_number').val(),$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn">call</i>
                        </a>
                        &nbsp;
                        <a>
                            <i style="cursor:pointer;" title="Random UK" data-title="Random UK" onclick="sipCall('call-audio','<?='88';?>'+$('#manual_call_number').val(),$('#manual_call_number').val(),$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn">call</i>
                        </a>
                        &nbsp;
                        <a>
                            <i style="cursor:pointer;" title="Mobile Random" data-title="Mobile Random" onclick="sipCall('call-audio','<?='66';?>'+$('#manual_call_number').val(),$('#manual_call_number').val(),$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn">call</i>
                        </a>
                        <a>
                            <i style="cursor:pointer;" title="Random CEL ITA" onclick="sipCall('call-audio','<?='67';?>'+$('#manual_call_number').val(),$('#manual_call_number').val(),$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn">call</i>
                        </a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
