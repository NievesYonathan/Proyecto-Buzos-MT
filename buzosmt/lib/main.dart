// import 'package:buzosmt/Presentation/screens/dashboard_screen.dart';
import 'package:flutter/material.dart';
import 'Presentation/screens/login_screen.dart';
import 'Presentation/screens/register_screen.dart'; // Asegúrate de que esta importación sea correcta

void main() {
  runApp(const BuzosMt());
}

class BuzosMt extends StatelessWidget {
  const BuzosMt({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'BuzosMt',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
      ),
      home: const MyHomePage(),
    );
  }
}

class MyHomePage extends StatelessWidget {
  const MyHomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            const Text('Bienvenido a BuzosMt'),
            const SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => Login()),
                );
              },
              child: const Text('Login'),
            ),
            const SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                // Navega a la pantalla de registro
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => RegisterScreen()),
                );
              },
              child: const Text('Regiter'),
            ),
          ],
        ),
      ),
    );
  }
}
