import 'package:echurchmobile/page/LoadWebView.dart';
import 'package:echurchmobile/shared/Session.dart';
import 'package:flutter/material.dart';

class Dashboard extends StatefulWidget {
  final Session? sess;

  Dashboard(this.sess);

  @override
  _dashboardState createState() => _dashboardState();
}

class _dashboardState extends State<Dashboard> {
  @override
  void initState() {
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: Drawer(
        child: ListView(
          children: [
            Container(
              width: double.infinity,
              height: this.widget.sess!.hight * 20,
              color: Colors.cyan,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.start,
                children: [
                  Padding(
                    padding: EdgeInsets.only(
                      left: this.widget.sess!.width * 2
                    ),
                    child: Container(
                      width: this.widget.sess!.width * 15,
                      height: this.widget.sess!.width * 15,
                      // color: Colors.black,
                      child: Icon(Icons.person, color: Colors.white,)
                    ),
                  ),
                  Container(
                    width: this.widget.sess!.width *55,
                    height: this.widget.sess!.hight *20,
                    // color: Colors.black,
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Padding(
                          padding: EdgeInsets.all(this.widget.sess!.width * 2),
                          child: Text(
                            "Selamat Datang :",
                            style: TextStyle(
                              fontSize: this.widget.sess!.width * 5
                            ),
                          ),
                        ),
                        Padding(
                          padding: EdgeInsets.only(
                            left: this.widget.sess!.width * 2
                          ),
                          child: Text(
                            this.widget.sess!.NamaUser,
                            style: TextStyle(
                              fontSize: this.widget.sess!.width * 4,
                              color: Colors.white
                            ),
                          ),
                        ),
                        Padding(
                          padding: EdgeInsets.all(this.widget.sess!.width * 2),
                          child: Text(
                            "App Version : " + this.widget.sess!.appVersion,
                          ),
                        )
                      ],
                    ),
                  )
                ],
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.sess!.width * 2,
                left: this.widget.sess!.width * 2,
                right: this.widget.sess!.width * 2
              ),
              child: Container(
                width: double.infinity,
                height: this.widget.sess!.hight * 7,
                child: GestureDetector(
                  child: Card(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: [
                        Icon(Icons.check_box),
                        Text(
                          "Konfirmasi Kehadiran Pelayanan"
                        ),
                        Icon(Icons.arrow_forward_rounded),
                      ],
                    ),
                  ),
                  onTap: (){
                    // Navigator.push(context,MaterialPageRoute(builder: (context) => GuestLog(this.widget.sess!)));
                  },
                ),
              )
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.sess!.width * 2,
                left: this.widget.sess!.width * 2,
                right: this.widget.sess!.width * 2
              ),
              child: Container(
                width: double.infinity,
                height: this.widget.sess!.hight * 7,
                child: GestureDetector(
                  child: Card(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: [
                        Icon(Icons.date_range),
                        Text(
                          "Absensi"
                        ),
                        Icon(Icons.arrow_forward_rounded),
                      ],
                    ),
                  ),
                  onTap: (){
                    Navigator.push(context,MaterialPageRoute(builder: (context) => LoadWebView(this.widget.sess!, this.widget.sess!.server+"pelayanan/absen")));
                  },
                ),
              )
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.sess!.width * 2,
                left: this.widget.sess!.width * 2,
                right: this.widget.sess!.width * 2
              ),
              child: Container(
                width: double.infinity,
                height: this.widget.sess!.hight * 7,
                child: GestureDetector(
                  child: Card(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: [
                        Icon(Icons.monetization_on),
                        Text(
                          "Setoran Bank"
                        ),
                        Icon(Icons.arrow_forward_rounded),
                      ],
                    ),
                  ),
                  onTap: (){
                    // Navigator.push(context,MaterialPageRoute(builder: (context) => GuestLog(this.widget.sess!)));
                  },
                ),
              )
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.sess!.width * 2,
                left: this.widget.sess!.width * 2,
                right: this.widget.sess!.width * 2
              ),
              child: Container(
                width: double.infinity,
                height: this.widget.sess!.hight * 7,
                child: GestureDetector(
                  child: Card(
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                      children: [
                        Icon(Icons.control_point_duplicate_rounded),
                        Text(
                          "Hitung Pemasukan"
                        ),
                        Icon(Icons.arrow_forward_rounded),
                      ],
                    ),
                  ),
                  onTap: (){
                    // Navigator.push(context,MaterialPageRoute(builder: (context) => GuestLog(this.widget.sess!)));
                  },
                ),
              )
            )
          ],
        ),
      ),
      appBar: AppBar(
        title: Text("Judul Aplikasi"),
      ),
      body: Container(
        child: Text(this.widget.sess!.CabangName),
      ),
    );
  }
}
