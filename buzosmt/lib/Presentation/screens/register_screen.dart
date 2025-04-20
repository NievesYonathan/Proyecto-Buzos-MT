import 'package:buzosmt/Domains/models/user_model.dart';
import 'package:buzosmt/Domains/usecases/getdocs_usecase.dart';
import 'package:flutter/material.dart';
import 'login_screen.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/customTextField.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/Customtextformfiel.dart';
import 'package:buzosmt/Presentation/Widgets/butons/customelevatedbutton.dart';
import 'package:buzosmt/Domains/usecases/login_user.dart';
import 'package:intl/intl.dart';
import 'package:fluttertoast/fluttertoast.dart';

class RegisterScreen extends StatelessWidget {
  const RegisterScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => FocusScope.of(context).unfocus(),
      child: Scaffold(
        body: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topCenter,
              end: Alignment.bottomCenter,
              colors: [Color(0xFF064c41), Color(0xFF20A67B)],
            ),
          ),
          child: SafeArea(
            child: Column(
              children: [
                // Header - Fixed at the top
                const Padding(
                  padding: EdgeInsets.only(top: 30.0, left: 24.0, bottom: 20.0),
                  child: Align(alignment: Alignment.centerLeft),
                ),

                // Scrollable content
                Expanded(
                  child: SingleChildScrollView(
                    physics: const BouncingScrollPhysics(),
                    child: Column(
                      children: [
                        // Main card with registration form
                        Container(
                          margin: const EdgeInsets.symmetric(
                            horizontal: 24,
                            vertical: 10,
                          ),
                          padding: const EdgeInsets.all(24),
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
                            children: [
                              // Logo
                              Padding(
                                padding: const EdgeInsets.only(bottom: 20.0),
                                child: Image.asset(
                                  'assets/images/image.png',
                                  height: 100,
                                  width: double.infinity,
                                  fit: BoxFit.contain,
                                ),
                              ),

                              // App name
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
                              const SizedBox(height: 30),

                              // Registration form
                              const _RegisterForm(),
                            ],
                          ),
                        ),

                        // Login option
                        Padding(
                          padding: const EdgeInsets.symmetric(vertical: 20),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              const Text(
                                "¿Ya tienes una cuenta? ",
                                style: TextStyle(
                                  color: Colors.white,
                                  fontSize: 14,
                                ),
                              ),
                              GestureDetector(
                                onTap: () {
                                  Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (context) => const LoginScreen(),
                                    ),
                                  );
                                },
                                child: const Text(
                                  "Iniciar Sesión",
                                  style: TextStyle(
                                    color: Color(0xFF064c41),
                                    fontSize: 14,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                        const SizedBox(height: 20),
                      ],
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

class _RegisterForm extends StatefulWidget {
  const _RegisterForm();

  @override
  State<_RegisterForm> createState() => _FormRegisterState();
}

class _FormRegisterState extends State<_RegisterForm> {
  final _formKey = GlobalKey<FormState>();
  List<DropdownMenuItem<int>> items = [];
  int? tDoc;
  Map<String, String> _errors = {};

  final TextEditingController tDocController = TextEditingController();
  final TextEditingController numDocController = TextEditingController();
  final TextEditingController usuNombresController = TextEditingController();
  final TextEditingController usuApellidosController = TextEditingController();
  final TextEditingController usuFechaNacimientoController =
      TextEditingController();
  final TextEditingController usuSexoController = TextEditingController();
  final TextEditingController usuTelefonoController = TextEditingController();
  final TextEditingController usuEmailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  final TextEditingController passwordConfirmationController =
      TextEditingController();

  @override
  void initState() {
    super.initState();
    cargarDocs().then((loadedItems) {
      setState(() {
        items = loadedItems;
      });
    });
  }

  Future<List<DropdownMenuItem<int>>> cargarDocs() async {
    final Tdoc tDocUseCase = Tdoc();
    final docs = await tDocUseCase.getDocumentosMap();
    return docs.entries
        .map((e) => DropdownMenuItem<int>(value: e.key, child: Text(e.value)))
        .toList();
  }

  Future<void> _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate:
          usuFechaNacimientoController.text.isNotEmpty
              ? DateFormat(
                'yyyy-MM-dd',
              ).parse(usuFechaNacimientoController.text)
              : DateTime.now(),
      firstDate: DateTime(1920),
      lastDate: DateTime.now(),
      builder: (context, child) {
        return Theme(
          data: Theme.of(context).copyWith(
            colorScheme: const ColorScheme.light(
              primary: Color(0xFF064c41),
              onPrimary: Colors.white,
              onSurface: Color(0xFF064c41),
            ),
            textButtonTheme: TextButtonThemeData(
              style: TextButton.styleFrom(
                foregroundColor: const Color(0xFF20A67B),
              ),
            ),
          ),
          child: child!,
        );
      },
    );

    if (picked != null) {
      setState(() {
        usuFechaNacimientoController.text = DateFormat(
          'dd-MM-yyyy',
        ).format(picked);
      });
    }
  }

  Future<void> dataValidate() async {
    FocusScope.of(context).unfocus();
    if (_formKey.currentState!.validate()) {
      print(usuFechaNacimientoController.text);
      UsesCasesUser validator = UsesCasesUser(
        User(
          tDoc: tDoc,
          numDoc: numDocController.text,
          usuNombres: usuNombresController.text,
          usuApellidos: usuApellidosController.text,
          usuFechaNacimiento: usuFechaNacimientoController.text,
          usuSexo: usuSexoController.text,
          usuTelefono: usuTelefonoController.text,
          usuEmail: usuEmailController.text,
          password: passwordController.text,
          passwordConfirmation: passwordConfirmationController.text,
        ),
      );
      final errors = validator.registerValidate();

      setState(() {
        _errors = errors;
      });

      if (_errors.isEmpty) {
        final status = await validator.registerUser();
        
        if (status['status'] != 'success') {
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

        Fluttertoast.showToast(
          msg: status['message'],
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          backgroundColor: const Color.fromARGB(255, 98, 244, 54),
          textColor: Colors.white,
          fontSize: 16.0,
        );
        Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => LoginScreen()),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
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
          const SizedBox(height: 8),

          // Document Type Dropdown
          Container(
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
                    decoration: const InputDecoration(
                      hintText: "Selecciona un tipo de documento",
                      border: InputBorder.none,
                      hintStyle: TextStyle(color: Colors.grey),
                      contentPadding: EdgeInsets.symmetric(vertical: 12),
                    ),
                    items: items,
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
          ),

          if (_errors['tDocError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['tDocError']!,
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          const SizedBox(height: 20),

          // Número de documento
          const Text(
            "Numero De Documento",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          _buildTextField(
            controller: numDocController,
            hintText: "Ingresa tu número de documento",
            icon: Icons.credit_card,
            errorText: _errors['numDocError'],
          ),

          const SizedBox(height: 20),

          // Nombres
          const Text(
            "Nombres",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          _buildTextField(
            controller: usuNombresController,
            hintText: "Ingresa tus nombres",
            icon: Icons.person,
            errorText: _errors['usuNombresError'],
          ),

          const SizedBox(height: 20),

          // Apellidos
          const Text(
            "Apellidos",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          _buildTextField(
            controller: usuApellidosController,
            hintText: "Ingresa tus apellidos",
            icon: Icons.person_outline,
            errorText: _errors['usuApellidosError'],
          ),

          const SizedBox(height: 20),

          // Fecha de nacimiento
          const Text(
            "Fecha de Nacimiento",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          // Date picker field
          Container(
            decoration: BoxDecoration(
              color: const Color(0xFFF5F5F5),
              borderRadius: BorderRadius.circular(30),
            ),
            child: Row(
              children: [
                const Padding(
                  padding: EdgeInsets.symmetric(horizontal: 16),
                  child: Icon(Icons.calendar_today, color: Colors.grey),
                ),
                Expanded(
                  child: TextFormField(
                    controller: usuFechaNacimientoController,
                    readOnly: true,
                    onTap: () => _selectDate(context),
                    decoration: const InputDecoration(
                      hintText: "DD/MM/AAAA",
                      border: InputBorder.none,
                      hintStyle: TextStyle(color: Colors.grey),
                      contentPadding: EdgeInsets.symmetric(vertical: 12),
                    ),
                  ),
                ),
                // Calendar icon button to open date picker
                IconButton(
                  icon: const Icon(Icons.event, color: Color(0xFF20A67B)),
                  onPressed: () => _selectDate(context),
                ),
              ],
            ),
          ),

          if (_errors['usuFechaError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['usuFechaError']!,
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          const SizedBox(height: 20),

          // Género
          const Text(
            "Género",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          Container(
            decoration: BoxDecoration(
              color: const Color(0xFFF5F5F5),
              borderRadius: BorderRadius.circular(30),
            ),
            child: Row(
              children: [
                const Padding(
                  padding: EdgeInsets.symmetric(horizontal: 16),
                  child: Icon(Icons.people_outline, color: Colors.grey),
                ),
                Expanded(
                  child: DropdownButtonFormField<String>(
                    decoration: const InputDecoration(
                      hintText: "Género",
                      border: InputBorder.none,
                      hintStyle: TextStyle(color: Colors.grey),
                      contentPadding: EdgeInsets.symmetric(vertical: 12),
                    ),
                    items: const [
                      DropdownMenuItem(value: 'M', child: Text('Masculino')),
                      DropdownMenuItem(value: 'F', child: Text('Femenino')),
                      DropdownMenuItem(value: 'O', child: Text('Otro')),
                    ],
                    onChanged: (value) {
                      setState(() {
                        usuSexoController.text = value ?? '';
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
          ),

          if (_errors['usuSexoError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['usuSexoError']!,
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          const SizedBox(height: 20),

          // Teléfono
          const Text(
            "Teléfono",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          _buildTextField(
            controller: usuTelefonoController,
            hintText: "Ingresa tu número de teléfono",
            icon: Icons.phone,
            errorText: _errors['usuTelError'],
          ),

          const SizedBox(height: 20),

          // Correo electrónico
          const Text(
            "Correo Electrónico",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          _buildTextField(
            controller: usuEmailController,
            hintText: "Ingresa tu correo electrónico",
            icon: Icons.email,
            errorText: _errors['usuEmailError'],
          ),

          const SizedBox(height: 20),

          // Contraseña
          const Text(
            "Contraseña",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          _buildTextField(
            controller: passwordController,
            hintText: "Ingresa tu contraseña",
            icon: Icons.lock_outline,
            isPassword: true,
            errorText: _errors['passwordError'],
          ),

          const SizedBox(height: 20),

          // Confirmar contraseña
          const Text(
            "Confirmar Contraseña",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          _buildTextField(
            controller: passwordConfirmationController,
            hintText: "Confirma tu contraseña",
            icon: Icons.lock_outline,
            isPassword: true,
            errorText: _errors['passwordConfirmationError'],
          ),

          const SizedBox(height: 30),

          // Register Button
          SizedBox(
            width: double.infinity,
            height: 55,
            child: ElevatedButton(
              onPressed: dataValidate,
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF20A67B),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(30),
                ),
                elevation: 0,
              ),
              child: const Text(
                "Registrarse",
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTextField({
    required TextEditingController controller,
    required String hintText,
    required IconData icon,
    String? errorText,
    bool isPassword = false,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Container(
          decoration: BoxDecoration(
            color: const Color(0xFFF5F5F5),
            borderRadius: BorderRadius.circular(30),
          ),
          child: Row(
            children: [
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16),
                child: Icon(icon, color: Colors.grey),
              ),
              Expanded(
                child: TextFormField(
                  controller: controller,
                  obscureText: isPassword,
                  decoration: InputDecoration(
                    hintText: hintText,
                    border: InputBorder.none,
                    hintStyle: const TextStyle(color: Colors.grey),
                    contentPadding: const EdgeInsets.symmetric(vertical: 12),
                  ),
                ),
              ),
            ],
          ),
        ),
        if (errorText != null)
          Padding(
            padding: const EdgeInsets.only(top: 4, left: 16),
            child: Text(
              errorText,
              style: const TextStyle(color: Colors.red, fontSize: 12),
            ),
          ),
      ],
    );
  }
}
