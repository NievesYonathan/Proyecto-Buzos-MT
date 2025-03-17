import 'package:flutter/material.dart';
import 'Presentation/Login.dart';
import 'Presentation/Register.dart';

void main() {
  runApp(const BuzosMt());
}

class BuzosMt extends StatelessWidget {
  const BuzosMt({super.key});
  
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Flutter Demo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
      ),
      home: const MyHomePage(),
    );
  }
}


//State<MyHomePage> createState() => _MyHomePageState();

class MyHomePage extends StatelessWidget {
  const MyHomePage({super.key});
  void login() {}

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
      ),
      body: Center(

        child: Column(
          
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            const Text('You have pushed the button this many times:'),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => Login()),
                );
              },
              child: Text('Login'),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                // Navigator.push(
                  // context,
                    // MaterialPageRoute(builder: (context) => Register()),
                // );
              },
              child: Text('Register'),
            ),
          ],
        ),
      ),
    );
  }
}
