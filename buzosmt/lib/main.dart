import 'package:flutter/material.dart';
import 'Presentation/screens/login_screen.dart';
import 'Presentation/screens/register_screen.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:buzosmt/Presentation/screens/dashboard_screen.dart';

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
        primarySwatch: Colors.blue,
        fontFamily: 'Roboto',
      ),
      home: const MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key});

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      checkSession();
    });
  }

  Future<void> checkSession() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');

    if (mounted && token != null) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const Dashboard()),
      );
    }
  }

  @override
 Widget build(BuildContext context) {
  return Scaffold(
    body: Stack(
      children: [
        // Imagen de fondo
        Positioned.fill(
          child: Image.asset(
            '../assets/images/verdecito.png',
            fit: BoxFit.cover,
          ),
        ),
        
        // Contenido principal
        Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              // Logo en la parte superior
              Image.asset(
                '../assets/images/image.png',
                height: 150,  // Ajusta este valor según necesites
                fit: BoxFit.contain,
                color: Colors.white, // Cambiado a blanco para mejor contraste
              ),
              const SizedBox(height: 30),
              
              // Texto "WELCOME"
              const Text(
                'Bienvenido a BuzosMt',
                style: TextStyle(
                  fontSize: 32,
                  fontWeight: FontWeight.bold,
                  color: Colors.white,
                ),
                textAlign: TextAlign.center,
              ),
              
              // Resto de tu contenido...
              const SizedBox(height: 30),
              const Text(
                'Do meditation. Stay focused.',
                style: TextStyle(
                  fontSize: 18,
                  color: Colors.white70,
                ),
                textAlign: TextAlign.center,
              ),
                const SizedBox(height: 10),
                const Text(
                  'Live a healthy life.',
                  style: TextStyle(
                    fontSize: 18,
                    color: Colors.white70,
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 50),
                ElevatedButton(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const LoginScreen()),
                    );
                  },
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF7C9A92), // Color verde
                    padding: const EdgeInsets.symmetric(vertical: 16),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(8),
                    ),
                    elevation: 5, // Sombra para mejor visibilidad
                  ),
                  child: const Text(
                    'Iniciar Sesión',
                    style: TextStyle(
                      fontSize: 16,
                      color: Colors.white,
                    ),
                  ),
                ),
                const SizedBox(height: 20),
                TextButton(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const RegisterScreen()),
                    );
                  },
                  child: const Text(
                    'No Tienes Una Cuenta? Registrarme',
                    style: TextStyle(
                      fontSize: 14,
                      color: Colors.white, // Cambiado a blanco para mejor contraste
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}