import 'dart:math';

import 'package:echurchmobile/page/Dashboard.dart';
import 'package:echurchmobile/page/LoadWebView.dart';
import 'package:echurchmobile/page/LoginPage.dart';
import 'package:echurchmobile/shared/sharedprefrence.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:echurchmobile/shared/notification_service.dart';
// import 'package:flutter_local_notifications/flutter_local_notifications.dart';

import 'package:echurchmobile/shared/Session.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:shared_preferences/shared_preferences.dart';

var notifdata;
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp();
  print('Handling a background message ${message.messageId}');
}

final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
    FlutterLocalNotificationsPlugin();

Future<void> init() async {
  final AndroidInitializationSettings androidInitializationSettings =
      AndroidInitializationSettings('app_icon');

  final InitializationSettings initializationSettings =
      InitializationSettings(android: androidInitializationSettings);
  await flutterLocalNotificationsPlugin.initialize(initializationSettings);
}

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();

  await Permission.camera.request();
  await Firebase.initializeApp();
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  // await FirebaseMessaging.instance.subscribeToTopic("SOSTopic");

  await FirebaseMessaging.instance.setForegroundNotificationPresentationOptions(
    alert: true,
    badge: true,
    sound: true,
  );

  NotificationSettings setting =
      await FirebaseMessaging.instance.requestPermission(
    alert: true,
    announcement: false,
    badge: true,
    carPlay: false,
    criticalAlert: false,
    provisional: false,
    sound: true,
  );

  print('User granted permission: ${setting.authorizationStatus}');

  
  runApp(MyApp());
}

class MyApp extends StatefulWidget {
  static final GlobalKey<NavigatorState> navigatorKey =
      GlobalKey<NavigatorState>();
  @override
  _MainState createState() => _MainState();
}

class _MainState extends State<MyApp> {
  Session sess = new Session();
  var kodeuser = "";
  String _Server = "";

  Future<String> _getData() async {
    var temp = await SharedPreference().getString("Server");
    return temp;
  }

  _fetchData() async {
    var temp = await _getData().then((value) {
      setState(() {
        // _data = value;
        _Server = value;
      });
    });
  }

  @override
  void initState() {
    _fetchData();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {

    ThemeData themeData(bool isDarkMode, BuildContext context) {
      return ThemeData(
        primaryColor: Color(0xFF125389),
        backgroundColor: isDarkMode ? Colors.black : Color(0xFFF1F5FB),
        indicatorColor: isDarkMode ? Color(0xFF0E1D36) : Color(0xFF226f54),
        hintColor: isDarkMode ? Color(0xFF280C0B) : Color(0xff133762),
        highlightColor: isDarkMode ? Color(0xFF372901) : Color(0xff133762),
        hoverColor: isDarkMode ? Color(0xFF3A3A3B) : Color(0xff133762),
        focusColor: isDarkMode ? Color(0xFF0B2512) : Color(0xff133762),
        disabledColor: Colors.grey,
        cardColor: isDarkMode ? Color(0xFF151515) : Colors.white,
        // canvasColor: Color(0xFF000031),
        brightness: isDarkMode ? Brightness.dark : Brightness.light,
        buttonTheme: Theme.of(context).buttonTheme.copyWith(
            colorScheme: isDarkMode ? ColorScheme.dark() : ColorScheme.light()),
        appBarTheme: AppBarTheme(
          elevation: 0,
        ),
        dividerColor: Colors.transparent
      );
    }
    return MaterialApp(
      // home: LoadWebView(sess, "https://system.tiberias.id/Home"),
      home: LoadWebView(sess, "http://192.168.1.66:8080/echurch/Home"),
    );
    // return MaterialApp(
    //     title: 'Patroli Siap x86',
    //     theme: themeData(false, context),
    //     home: FutureBuilder(
    //         future: SharedPreference().getString("accountInfo"),
    //         builder: (context, snapshot) {
    //           var width = MediaQuery.of(context).size.width / 100;
    //           var height = MediaQuery.of(context).size.height / 100;

    //           if (snapshot.hasData && snapshot.data != "") {
    //             var xData = snapshot.data.toString().split("|");
    //             sess.idUser =int.parse(xData[0]);
    //             sess.NamaUser = xData[1];
    //             sess.KodeUser = xData[2];
    //             sess.CabangID = int.parse(xData[3]);
    //             sess.CabangName = xData[4];
    //             sess.NIK = xData[5];
    //             sess.hight = height;
    //             sess.width = width;
                
                
    //             return Dashboard(sess);
    //           } else {
    //             var width = MediaQuery.of(context).size.width / 100;
    //             var height = MediaQuery.of(context).size.height / 100;

    //             sess.hight = height;
    //             sess.width = width;
    //             return LoginMobilePotrait(sess);
    //           }
    //         }
    //       )
          
    //     );
  }
}
