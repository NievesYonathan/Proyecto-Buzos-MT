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
      theme: ThemeData(primarySwatch: Colors.green, fontFamily: 'Roboto'),
      home: const MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key});

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> with SingleTickerProviderStateMixin {
  late AnimationController _animationController;
  late Animation<Offset> _loginButtonAnimation;
  late Animation<Offset> _registerButtonAnimation;

  @override
  void initState() {
    super.initState();

    _animationController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 1500),
    );

    _loginButtonAnimation = Tween<Offset>(
      begin: const Offset(-1.5, 0.0),
      end: Offset.zero,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: const Interval(0.1, 0.6, curve: Curves.easeInOutQuad),
    ));

    _registerButtonAnimation = Tween<Offset>(
      begin: const Offset(1.5, 0.0),
      end: Offset.zero,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: const Interval(0.3, 0.8, curve: Curves.easeInOutQuad),
    ));

    WidgetsBinding.instance.addPostFrameCallback((_) {
      checkSession();
      _animationController.forward();
    });
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }

  Future<void> checkSession() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');
    if (mounted && token != null && token != '') {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const Dashboard()),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final size = MediaQuery.of(context).size;

    return Scaffold(
      body: Stack(
        children: [
          Positioned.fill(
            child: Image.asset(
              'assets/images/verdecito.png',
              fit: BoxFit.cover,
            ),
          ),
          SafeArea(
            child: Column(
              children: [
                SizedBox(
                  height: size.height * 0.35,
                  child: Center(
                    child: Image.asset(
                      'assets/images/image.png',
                      height: size.height * 0.3,
                      color: Colors.white,
                    ),
                  ),
                ),
                Expanded(
                  child: Padding(
                    padding: EdgeInsets.symmetric(horizontal: size.width * 0.06),
                    child: Column(
                      children: [
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
                        SizedBox(height: size.height * 0.02),
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
                        SizedBox(height: size.height * 0.1),
                        SlideTransition(
                          position: _loginButtonAnimation,
                          child: SizedBox(
                            width: double.infinity,
                            height: size.height * 0.07,
                            child: ElevatedButton(
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                    builder: (context) => const LoginScreen(),
                                  ),
                                );
                              },
                              style: ElevatedButton.styleFrom(
                                backgroundColor: const Color(0xFF064c41),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(8),
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
                        ),
                        SizedBox(height: size.height * 0.02),
                        SlideTransition(
                          position: _registerButtonAnimation,
                          child: SizedBox(
                            width: double.infinity,
                            height: size.height * 0.07,
                            child: ElevatedButton(
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                    builder: (context) => const RegisterScreen(),
                                  ),
                                );
                              },
                              style: ElevatedButton.styleFrom(
                                backgroundColor: const Color(0xFF20A67B),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(8),
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
                        ),
                        const Spacer(),
                        Container(
                          width: size.width * 0.1,
                          height: size.height * 0.005,
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(3),
                          ),
                        ),
                        SizedBox(height: size.height * 0.01),
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
