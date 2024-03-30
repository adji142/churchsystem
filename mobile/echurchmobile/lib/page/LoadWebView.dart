import 'package:flutter/material.dart';
import 'package:echurchmobile/shared/Session.dart';
import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:url_launcher/url_launcher.dart';

class LoadWebView extends StatefulWidget {
  final Session? sess;
  final String? link;

  LoadWebView(this.sess, this.link);

  @override
  _WebViewState createState() => _WebViewState();
}

class _WebViewState extends State<LoadWebView> {
  final GlobalKey webViewKey = GlobalKey();
  InAppWebViewController? webViewController;

  Future<void> checkAndRequestPermissions() async {
    PermissionStatus status = await Permission.camera.status;
    if (!status.isGranted) {
      await Permission.camera.request();
    }
  }
  @override
  void initState() {
    checkAndRequestPermissions();
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("GEREJA TIBERIAS INDONESIA"),
      ),
      body: InAppWebView(
        key: webViewKey,
        // this.widget.link.toString()
        initialUrlRequest: URLRequest(url: Uri.parse(this.widget.link.toString())),
        initialOptions: InAppWebViewGroupOptions(
          crossPlatform: InAppWebViewOptions(
            javaScriptEnabled:  true,
            mediaPlaybackRequiresUserGesture: false
          ),
          android: AndroidInAppWebViewOptions(
            useShouldInterceptRequest: true
          )
        ),
        onWebViewCreated: (controller) {
          webViewController = controller;
        },
        androidOnPermissionRequest: (InAppWebViewController controller, String origin, List<String> resources) async {
          return PermissionRequestResponse(resources: resources, action: PermissionRequestResponseAction.GRANT);
        },
      )
    );
  }
}
