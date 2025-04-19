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
        primarySwatch: Colors.green,
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
          // Imagen de fondo con ondas (verdecito.png)
          Positioned.fill(
            child: Image.asset(
              'assets/images/verdecito.png',
              fit: BoxFit.cover,
            ),
          ),

          // Contenido principal
          SafeArea(
            child: Column(
              children: [
                // Sección del logo con tamaño fijo
                SizedBox(
                  height: 300, // Ajustado para posicionar el contenido
                  child: Center(
                    child: Image.asset(
                      'assets/images/image.png',
                      height: 280, // Ajustado proporcionalmente
                      color: Colors.white,
                    ),
                  ),
                ),

                // Contenido de texto y botones
                Expanded(
                  child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 24.0),
                    child: Column(
                      children: [
                        // Título BuzosMT
                        const Text(
                          'Buzos MT',
                          style: TextStyle(
                            fontSize: 30,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                            letterSpacing: 1.2,
                          ),
                          textAlign: TextAlign.center,
                        ),
                        const SizedBox(height: 10),
                        // Subtítulo
                        const Text(
                          'La mejor calidad',
                          style: TextStyle(
                            fontSize: 28,
                            fontWeight: FontWeight.w400,
                            color: Colors.white,
                          ),
                          textAlign: TextAlign.center,
                        ),
                        const Text(
                          'en tus manos',
                          style: TextStyle(
                            fontSize: 28,
                            fontWeight: FontWeight.w400,
                            color: Colors.white,
                          ),
                          textAlign: TextAlign.center,
                        ),
                        
                        // Espacio ajustable - aumentado para bajar un poco los botones
                        const SizedBox(height: 120),
                        
                        // Botones con esquinas cuadradas pero sin borde blanco
                        // Botón de Iniciar Sesión
                        SizedBox(
                          width: double.infinity,
                          height: 56,
                          child: ElevatedButton(
                            onPressed: () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(builder: (context) => const LoginScreen()),
                              );
                            },
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color(0xFF064c41),
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(8), // Esquinas cuadradas
                              ),
                              elevation: 0,
                            ),
                            child: const Text(
                              'Iniciar Sesión',
                              style: TextStyle(
                                fontSize: 20,
                                fontWeight: FontWeight.w500,
                                color: Colors.white,
                              ),
                            ),
                          ),
                        ),
                        const SizedBox(height: 16),
                        // Botón de Registrarme
                        SizedBox(
                          width: double.infinity,
                          height: 56,
                          child: ElevatedButton(
                            onPressed: () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(builder: (context) => const RegisterScreen()),
                              );
                            },
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color(0xFF20A67B),
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(8), // Esquinas cuadradas
                              ),
                              elevation: 0,
                            ),
                            child: const Text(
                              'Registrarme',
                              style: TextStyle(
                                fontSize: 20,
                                fontWeight: FontWeight.w500,
                                color: Colors.white,
                              ),
                            ),
                          ),
                        ),
                        
                        const Spacer(), // Empuja el indicador al final
                        
                        // Indicador de página (línea blanca en la parte inferior)
                        Container(
                          width: 40,
                          height: 5,
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(3),
                          ),
                        ),
                        const SizedBox(height: 10),
                      ],
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