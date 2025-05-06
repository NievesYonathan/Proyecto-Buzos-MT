import '../../Domains/models/user_model.dart';
import 'dashboard_screen.dart';
import 'package:flutter/material.dart';
// import '../Widgets/Inputs/customTextField.dart';
// import '../Widgets/Inputs/Customtextformfiel.dart';
import '../../Domains/usecases/login_user.dart';
import '../../Domains/usecases/getdocs_usecase.dart';
import 'package:fluttertoast/fluttertoast.dart';
// import '../Widgets/butons/customelevatedbutton.dart';
import 'register_screen.dart';
import 'forgot_password_screen.dart';
import '../../main.dart';
import 'package:google_sign_in/google_sign_in.dart';

class LoginScreen extends StatelessWidget {
  const LoginScreen({super.key});

  Future<void> _signInWithGoogle(BuildContext context) async {
    try {
      final GoogleSignIn googleSignIn = GoogleSignIn();
      final GoogleSignInAccount? googleUser = await googleSignIn.signIn();

      if (googleUser == null) {
        // El usuario canceló el inicio de sesión
        return;
      }

      final GoogleSignInAuthentication googleAuth =
          await googleUser.authentication;

      // Aquí obtienes el token de acceso y el ID token
      final String? accessToken = googleAuth.accessToken;
      final String? idToken = googleAuth.idToken;

      // Simulate fetching user data using the idToken or accessToken
      final userData = {
        'usu_nombres': googleUser.displayName,
        'email': googleUser.email,
        'imag_perfil': googleUser.photoUrl,
      };

      // Pass user data to the Dashboard
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => Dashboard(userData: userData)),
      );

    } catch (e) {
      // Maneja errores de inicio de sesión
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Error al iniciar sesión con Google: $e")),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    // Obtenemos el tamaño de la pantalla
    final Size screenSize = MediaQuery.of(context).size;
    final bool isSmallScreen = screenSize.width < 600;
    final double cardWidth = isSmallScreen ? screenSize.width : 500;
    
    return Scaffold(
      body: GestureDetector(
        onTap: () => FocusScope.of(context).unfocus(),
        child: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topCenter,
              end: Alignment.bottomCenter,
              colors: [Color(0xFF064c41), Color(0xFF20A67B)],
            ),
          ),
          child: SafeArea(
            child: Center(
              child: SingleChildScrollView(
                child: Padding(
                  padding: EdgeInsets.symmetric(
                    horizontal: isSmallScreen ? 16.0 : 24.0,
                    vertical: 24.0,
                  ),
                  child: Column(
                    children: [
                      // Main card with logo and login form
                      Container(
                        width: cardWidth,
                        padding: EdgeInsets.all(isSmallScreen ? 16.0 : 24.0),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(30),
                          boxShadow: [
                            BoxShadow(
                              color: Colors.black.withOpacity(0.1),
                              blurRadius: 10,
                              offset: const Offset(0, 5),
                            ),
                          ],
                        ),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            // Botón con flecha hacia la izquierda
                            InkWell(
                              onTap: () {
                                Navigator.pushReplacement(
                                  context,
                                  MaterialPageRoute(
                                    builder: (context) => const BuzosMt(),
                                  ),
                                );
                              },
                              child: Container(
                                padding: const EdgeInsets.all(8),
                                decoration: BoxDecoration(
                                  color: const Color(0xFFF5F5F5),
                                  borderRadius: BorderRadius.circular(12),
                                ),
                                child: const Icon(
                                  Icons.arrow_back,
                                  color: Color(0xFF064c41),
                                  size: 24,
                                ),
                              ),
                            ),
                            SizedBox(height: isSmallScreen ? 8 : 12),

                            // Logo (reemplazar con tu imagen)
                            Center(
                              child: Padding(
                                padding: const EdgeInsets.only(bottom: 20.0),
                                child: Image.asset(
                                  'assets/images/image.png',
                                  height: isSmallScreen ? 100 : 130,
                                  width: double.infinity,
                                  fit: BoxFit.contain,
                                ),
                              ),
                            ),

                            // App name "LOGIN PAGE"
                            const Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Text(
                                  "BUZOS",
                                  style: TextStyle(
                                    color: Color(0xFF064c41),
                                    fontSize: 32,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(
                                  "MT",
                                  style: TextStyle(
                                    color: Color(0xFF20A67B),
                                    fontSize: 28,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              ],
                            ),
                            SizedBox(height: isSmallScreen ? 20 : 30),

                            // Login form content
                            const _LoginFormContent(),

                            SizedBox(height: isSmallScreen ? 15 : 20),

                            // Google Login Button
                            Center(
                              child: ConstrainedBox(
                                constraints: BoxConstraints(
                                  maxWidth: isSmallScreen ? double.infinity : 300,
                                ),
                                child: ElevatedButton.icon(
                                  onPressed: () => _signInWithGoogle(context),
                                  style: ElevatedButton.styleFrom(
                                    backgroundColor: Colors.white,
                                    foregroundColor: Colors.grey[800],
                                    padding: EdgeInsets.symmetric(
                                      vertical: isSmallScreen ? 10 : 13,
                                      horizontal: 12,
                                    ),
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(30),
                                      side: BorderSide(color: Colors.grey[300]!),
                                    ),
                                    elevation: 2,
                                  ),
                                  icon: Image.asset(
                                    'assets/images/google.png',
                                    height: 24,
                                    width: 24,
                                  ),
                                  label: Text(
                                    "Iniciar Sesión con Google",
                                    style: TextStyle(fontSize: isSmallScreen ? 14 : 16),
                                  ),
                                ),
                              ),
                            )
                          ],
                        ),
                      ),

                      // Sign up option
                      SizedBox(height: isSmallScreen ? 15 : 20),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Text(
                            "No Tienes Una Cuenta? ",
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: isSmallScreen ? 12 : 14,
                            ),
                          ),
                          GestureDetector(
                            onTap: () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(
                                  builder: (context) => const RegisterScreen(),
                                ),
                              );
                            },
                            child: Text(
                              "Registrarme",
                              style: TextStyle(
                                color: const Color(0xFF064c41),
                                fontSize: isSmallScreen ? 12 : 14,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class _LoginFormContent extends StatefulWidget {
  const _LoginFormContent();

  @override
  State<_LoginFormContent> createState() => _LoginFormContentState();
}

class _LoginFormContentState extends State<_LoginFormContent> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  int? tDoc;
  final TextEditingController numDocController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  late Future<List<DropdownMenuItem<int>>> itemsFuture;
  Map<String?, dynamic> _errors = {};

  @override
  void initState() {
    super.initState();
    itemsFuture = cargarDocs();
  }

  Future<List<DropdownMenuItem<int>>> cargarDocs() async {
    final Tdoc tDocUseCase = Tdoc();
    final docs = await tDocUseCase.getDocumentosMap();
    return docs.entries
        .map((e) => DropdownMenuItem<int>(value: e.key, child: Text(e.value)))
        .toList();
  }

  Future<void> dataValidate() async {
    FocusScope.of(context).unfocus();
    if (_formKey.currentState!.validate()) {
      UsesCasesUser validator = UsesCasesUser(
        User(
          tDoc: tDoc,
          numDoc: numDocController.text,
          password: passwordController.text,
        ),
      );
      
      final errors = validator.loginValidate();

      setState(() {
        _errors = errors;
      });
      if (_errors.isEmpty) {
        final status = await validator.loginUser();
        if (status['status'] != 'success') {
          numDocController.clear();
          passwordController.clear();
          // Handle error
          Fluttertoast.showToast(
            msg: status['message'],
            toastLength: Toast.LENGTH_SHORT,
            gravity: ToastGravity.BOTTOM,
            backgroundColor: Colors.red,
            textColor: Colors.white,
            fontSize: 16.0,
          );
          return;
        }

        Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => Dashboard(userData: status['user'])),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    // Obtenemos el tamaño de la pantalla
    final Size screenSize = MediaQuery.of(context).size;
    final bool isSmallScreen = screenSize.width < 600;
    
    return Form(
      key: _formKey,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Tipo de documento
          const Text(
            "Tipo De Documento",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          SizedBox(height: isSmallScreen ? 6 : 8),

          // Document Type Dropdown
          FutureBuilder<List<DropdownMenuItem<int>>>(
            future: itemsFuture,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Center(child: CircularProgressIndicator());
              } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                return const Text('No hay datos disponibles');
              } else {
                return Container(
                  decoration: BoxDecoration(
                    color: const Color(0xFFF5F5F5),
                    borderRadius: BorderRadius.circular(30),
                  ),
                  child: Row(
                    children: [
                      const Padding(
                        padding: EdgeInsets.symmetric(horizontal: 16),
                        child: Icon(Icons.badge, color: Colors.grey),
                      ),
                      Expanded(
                        child: DropdownButtonFormField<int>(
                          value: tDoc,
                          decoration: InputDecoration(
                            hintText: "Selecciona un tipo de documento",
                            border: InputBorder.none,
                            hintStyle: const TextStyle(color: Colors.grey),
                            contentPadding: EdgeInsets.symmetric(
                              vertical: isSmallScreen ? 10 : 12,
                            ),
                          ),
                          items: snapshot.data,
                          onChanged: (value) {
                            setState(() {
                              tDoc = value;
                            });
                          },
                          icon: const Icon(
                            Icons.arrow_drop_down,
                            color: Color(0xFF064c41),
                          ),
                          isExpanded: true,
                          dropdownColor: Colors.white,
                        ),
                      ),
                    ],
                  ),
                );
              }
            },
          ),

          if (_errors['tDocError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['tDocError'],
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          SizedBox(height: isSmallScreen ? 15 : 20),

          // Número de documento
          const Text(
            "Numero De Documento",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          SizedBox(height: isSmallScreen ? 6 : 8),

          // Document Number Field
          Container(
            decoration: BoxDecoration(
              color: const Color(0xFFF5F5F5),
              borderRadius: BorderRadius.circular(30),
            ),
            child: Row(
              children: [
                const Padding(
                  padding: EdgeInsets.symmetric(horizontal: 16),
                  child: Icon(Icons.person_outline, color: Colors.grey),
                ),
                Expanded(
                  child: TextFormField(
                    controller: numDocController,
                    decoration: InputDecoration(
                      hintText: "Ingresa tu número de documento",
                      border: InputBorder.none,
                      hintStyle: const TextStyle(color: Colors.grey),
                      contentPadding: EdgeInsets.symmetric(
                        vertical: isSmallScreen ? 10 : 12,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),

          if (_errors['numDocError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['numDocError'],
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          SizedBox(height: isSmallScreen ? 15 : 20),

          // Password Field
          const Text(
            "Contaseña",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          SizedBox(height: isSmallScreen ? 6 : 8),

          Container(
            decoration: BoxDecoration(
              color: const Color(0xFFF5F5F5),
              borderRadius: BorderRadius.circular(30),
            ),
            child: Row(
              children: [
                const Padding(
                  padding: EdgeInsets.symmetric(horizontal: 16),
                  child: Icon(Icons.lock_outline, color: Colors.grey),
                ),
                Expanded(
                  child: TextFormField(
                    controller: passwordController,
                    obscureText: true,
                    decoration: InputDecoration(
                      hintText: "Ingresa tu contraseña",
                      border: InputBorder.none,
                      hintStyle: const TextStyle(color: Colors.grey),
                      contentPadding: EdgeInsets.symmetric(
                        vertical: isSmallScreen ? 10 : 12,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),

          if (_errors['passwordError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['passwordError'],
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          SizedBox(height: isSmallScreen ? 12 : 16),

          // Forgot password - ahora alineado a la derecha sin el checkbox
          Align(
            alignment: Alignment.centerRight,
            child: GestureDetector(
              onTap: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => const ForgotPasswordScreen(),
                  ),
                );
              },
              child: const Text(
                "Olvide Mi Contraseña",
                style: TextStyle(color: Color(0xFF20A67B), fontSize: 14),
              ),
            ),
          ),
                
          SizedBox(height: isSmallScreen ? 20 : 30),

          // Sign In Button
          SizedBox(
            width: double.infinity,
            height: isSmallScreen ? 48 : 55,
            child: ElevatedButton(
              onPressed: dataValidate,
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF20A67B),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(30),
                ),
                elevation: 0,
              ),
              child: Text(
                "Iniciar Sesión",
                style: TextStyle(
                  color: Colors.white,
                  fontSize: isSmallScreen ? 14 : 16,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}