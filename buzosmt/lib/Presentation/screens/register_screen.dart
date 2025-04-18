import 'package:buzosmt/Domains/models/user_model.dart';
import 'package:buzosmt/Domains/usecases/getdocs_usecase.dart';
import 'package:flutter/material.dart';
import 'login_screen.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/customTextField.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/Customtextformfiel.dart';
import 'package:buzosmt/Presentation/Widgets/butons/customelevatedbutton.dart';
import 'package:buzosmt/Domains/usecases/login_user.dart';

class RegisterScreen extends StatelessWidget {
  const RegisterScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => FocusScope.of(context).unfocus(),
      child: const Scaffold(
        body: Stack(
          children: [
            RegisterHeader(),
            // Elimina esta línea para evitar duplicar el formulario
            // _RegisterForm(),
          ],
        ),
      ),
    );
  }
}

class RegisterHeader extends StatelessWidget {
  const RegisterHeader({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Container(
            height: double.infinity,
            width: double.infinity,
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                colors: [
                  Color.fromARGB(255, 15, 52, 67),
                  Color.fromARGB(255, 52, 230, 159),
                ],
              ),
            ),
            child: const Padding(
              padding: EdgeInsets.only(top: 60.0, left: 22),
              child: Text(
                'Registro\nUsuario',
                style: TextStyle(
                  fontSize: 30,
                  color: Colors.white,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(top: 200.0),
            child: Container(
              decoration: const BoxDecoration(
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(40),
                  topRight: Radius.circular(40),
                ),
                color: Colors.white,
              ),
              height: double.infinity,
              width: double.infinity,
              child: Padding(
                padding: const EdgeInsets.symmetric(
                  horizontal: 25.0,
                  vertical: 20.0,
                ),
                child: _RegisterForm(),
              ),
            ),
          ),
        ],
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

  Future<void> dataValidate() async {
    FocusScope.of(context).unfocus();
    if (_formKey.currentState!.validate()) {
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
        print(status);
        if (status['status'] != 'success') {
          
          // Fluttertoast.showToast(
          //   msg: status['message'],
          //   toastLength: Toast.LENGTH_SHORT,
          //   gravity: ToastGravity.BOTTOM,
          //   backgroundColor: const Color.fromARGB(255, 255, 0, 0),
          //   textColor: Colors.white,
          //   fontSize: 16.0,
          // );
          return;
        }
        // Fluttertoast.showToast(
        //   msg: status['message'],
        //   toastLength: Toast.LENGTH_SHORT,
        //   gravity: ToastGravity.BOTTOM,
        //   backgroundColor: const Color.fromARGB(255, 9, 255, 0),
        //   textColor: Colors.white,
        //   fontSize: 16.0,
        // );

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
      child: ListView(
        padding: const EdgeInsets.only(top: 20),
        children: [
          CustomDropdownButtonFormField(
            labelText: 'Tipo de documento',
            items: items,
            prefixIcon: Icons.badge,
            error: _errors['tDocError'],
            onChanged: (value) {
              setState(() {
                tDoc = value;
              });
            },
          ),
          CustomTextFormFiel(
            controller: numDocController,
            labelText: 'Número de documento',
            prefixIcon: Icons.credit_card,
            error: _errors['numDocError'],
          ),
          CustomTextFormFiel(
            controller: usuNombresController,
            labelText: 'Nombres',
            prefixIcon: Icons.person,
            error: _errors['usuNombresError'],
          ),
          CustomTextFormFiel(
            controller: usuApellidosController,
            labelText: 'Apellidos',
            prefixIcon: Icons.person_outline,
            error: _errors['usuApellidosError'],
          ),
          CustomTextFormFiel(
            controller: usuFechaNacimientoController,
            labelText: 'Fecha de nacimiento',
            prefixIcon: Icons.calendar_today,
            error: _errors['usuFechaError'],
          ),
          DropdownButtonFormField<String>(
            decoration: InputDecoration(
              labelText: 'Género',
              prefixIcon: Icon(Icons.badge),
              errorText: _errors['usuSexoError'],
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(8.0),
              ),
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
          ),
          CustomTextFormFiel(
            controller: usuTelefonoController,
            labelText: 'Teléfono',
            prefixIcon: Icons.phone,
            error: _errors['usuTelError'],
          ),
          CustomTextFormFiel(
            controller: usuEmailController,
            labelText: 'Correo electrónico',
            prefixIcon: Icons.email,
            error: _errors['usuEmailError'],
          ),
          CustomTextFormFiel(
            controller: passwordController,
            labelText: 'Contraseña',
            prefixIcon: Icons.lock,
            isPassword: true,
            error: _errors['passwordError'],
          ),
          CustomTextFormFiel(
            controller: passwordConfirmationController,
            labelText: 'Confirmar contraseña',
            prefixIcon: Icons.lock_outline,
            isPassword: true,
            error: _errors['passwordConfirmationError'],
          ),
          SizedBox(height: 20),
          CustomElevatedButton(text: 'Registrate', onPressed: dataValidate),
        ],
      ),
    );
  }
}
