<html>
    <head>
        <title>Ant Media Server WebRTC Audio Publish</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
            integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
            crossorigin="anonymous">
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <style>
            video {
            width: 100%;
            max-width: 640px;
            }
            /* Space out content a bit */
            body {
            padding-top: 20px;
            padding-bottom: 20px;
            }
            /* Everything but the jumbotron gets side spacing for mobile first views */
            .header, .marketing, .footer {
            padding-right: 15px;
            padding-left: 15px;
            }
            /* Custom page header */
            .header {
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e5e5;
            }
            /* Make the masthead heading the same height as the navigation */
            .header h3 {
            margin-top: 0;
            margin-bottom: 0;
            line-height: 40px;
            }
            /* Custom page footer */
            .footer {
            padding-top: 19px;
            color: #777;
            border-top: 1px solid #e5e5e5;
            }
            /* Customize container */
            @media ( min-width : 768px) {
            .container {
            max-width: 730px;
            }
            }
            .container-narrow>hr {
            margin: 30px 0;
            }
            /* Main marketing message and sign up button */
            .jumbotron {
            text-align: center;
            border-bottom: 1px solid #e5e5e5;
            }
            /* Responsive: Portrait tablets and up */
            @media screen and (min-width: 768px) {
            /* Remove the padding we set earlier */
            .header, .marketing, .footer {
            padding-right: 0;
            padding-left: 0;
            }
            /* Space out the masthead */
            .header {
            margin-bottom: 30px;
            }
            /* Remove the bottom border on the jumbotron for visual effect */
            .jumbotron {
            border-bottom: 0;
            }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">WebRTC Publish</h3>
            </div>
            <div class="jumbotron">
                <p>
                    <audio id="localVideo" autoplay controls muted></audio>
                </p>
                <p>
                    <input type="text" class="form-control" value="stream1" id="streamName" placeholder="Type stream name">
                </p>
                <p>
                    <button class="btn btn-info" disabled id="start_publish_button">Start Publishing</button>
                    <button class="btn btn-info" disabled id="stop_publish_button">Stop Publishing</button>
                </p>
                <span class="label label-success" id="broadcastingInfo" style="font-size:14px;display:none"
                    style="display: none">Publishing</span>
            </div>
            <footer class="footer">
                <!-- <p><a href="http://antmedia.io">Ant Media Server Enterprise Edition</a></p> -->
            </footer>
        </div>
    </body>
    <script type="module">
        import {WebRTCAdaptor} from "{{ asset('/js/webrtc_adaptor.js') }}"
        
        var start_publish_button = document.getElementById("start_publish_button");
        start_publish_button.addEventListener("click", startPublishing, false);
        var stop_publish_button = document.getElementById("stop_publish_button");
        stop_publish_button.addEventListener("click", stopPublishing, false);
        
        var streamNameBox = document.getElementById("streamName");
        
        var streamId;
        
        function startPublishing() {
            streamId = streamNameBox.value;
            webRTCAdaptor.publish(streamId);
        }
        
        function stopPublishing() {
            webRTCAdaptor.stop(streamId);
        }
        
        function startAnimation() {
            $("#broadcastingInfo").fadeIn(800, function () {
                $("#broadcastingInfo").fadeOut(800, function () {
                    var state = webRTCAdaptor.signallingState(streamId);
                    if (state != null && state != "closed") {
                        var iceState = webRTCAdaptor.iceConnectionState(streamId);
                        if (iceState != null && iceState != "failed" && iceState != "disconnected") {
                            startAnimation();
                        }
                    }
                });
            });
        }
        
        var pc_config = null;
        
        var sdpConstraints = {
            OfferToReceiveAudio : false,
            OfferToReceiveVideo : false
        };
        
        var mediaConstraints = {
            video : false,
            audio : true
        };

        var ip = "67.205.185.92";
        
        var appName = location.pathname.substring(0, location.pathname.lastIndexOf("/")+1);
        var websocketURL = "ws://" + ip + ":5080/" + "WebRTCAppEE/websocket";
        
        if (location.protocol.startsWith("https")) {
            websocketURL = "wss://" + ip + ":5443/" + + "WebRTCAppEE/websocket";
        }

        console.log(websocketURL);
        
        
        var webRTCAdaptor = new WebRTCAdaptor({
            websocket_url : websocketURL,
            mediaConstraints : mediaConstraints,
            peerconnection_config : pc_config,
            sdp_constraints : sdpConstraints,
            localVideoId : "localVideo",
            debug:true,
            callback : function(info, description) {
                if (info == "initialized") {
                    console.log("initialized");
                    start_publish_button.disabled = false;
                    stop_publish_button.disabled = true;
                } else if (info == "publish_started") {
                    //stream is being published
                    console.log("publish started");
                    start_publish_button.disabled = true;
                    stop_publish_button.disabled = false;
                    startAnimation();
                } else if (info == "publish_finished") {
                    //stream is being finished
                    console.log("publish finished");
                    start_publish_button.disabled = false;
                    stop_publish_button.disabled = true;
                } else if (info == "closed") {
                    //console.log("Connection closed");
                    if (typeof description != "undefined") {
                        console.log("Connecton closed: " + JSON.stringify(description));
                    }
                }
            },
            callbackError : function(error, message) {
                console.log("error callback: " +  JSON.stringify(error));
                var errorMessage = JSON.stringify(error);
                if (typeof message != "undefined") {
                    errorMessage = message;
                }
                var errorMessage = JSON.stringify(error);
                if (error.indexOf("NotFoundError") != -1) {
                    errorMessage = "Camera or Mic are not found or not allowed in your device";
                }
                else if (error.indexOf("NotReadableError") != -1 || error.indexOf("TrackStartError") != -1) {
                    errorMessage = "Camera or Mic is being used by some other process that does not let read the devices";
                }
                else if(error.indexOf("OverconstrainedError") != -1 || error.indexOf("ConstraintNotSatisfiedError") != -1) {
                    errorMessage = "There is no device found that fits your video and audio constraints. You may change video and audio constraints"
                }
                else if (error.indexOf("NotAllowedError") != -1 || error.indexOf("PermissionDeniedError") != -1) {
                    errorMessage = "You are not allowed to access camera and mic.";
                }
                else if (error.indexOf("TypeError") != -1) {
                    errorMessage = "Video/Audio is required";
                }
            
                alert(errorMessage);
            }
        });
    </script>
</html>