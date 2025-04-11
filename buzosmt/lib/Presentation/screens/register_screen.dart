import 'package:buzosmt/Domains/models/user_model.dart';
import 'package:buzosmt/Domains/usecases/getdocs_usecase.dart';
import 'package:flutter/material.dart';
import 'login_screen.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/customTextField.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/Customtextformfiel.dart';
import 'package:buzosmt/Presentation/Widgets/butons/customelevatedbutton.dart';

class RegisterScreen extends StatelessWidget {
  const RegisterScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => FocusScope.of(context).unfocus(),
      child: const Scaffold(
        body: Stack(children: [RegisterHeader(), _RegisterForm()]),
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

  @override
  void initState() {
    super.initState();
    cargarDocs();
  }

  Future<void> cargarDocs() async {
    final Tdoc tDocUseCase = Tdoc();
    final docs = await tDocUseCase.getDocumentosMap();

    items =
        docs.entries
            .map(
              (e) => DropdownMenuItem<int>(value: e.key, child: Text(e.value)),
            )
            .toList();
  }

  @override
  Widget build(BuildContext context) {
    return Form(
      key: _formKey,
      child: ListView(
        padding: const EdgeInsets.only(top: 20),
        children: [
          // CustomDropdownButtonFormField(
          //   labelText: 'Tipo de documento',
          //   items: items,
          //   prefixIcon: Icons.badge,
          //   // error: _errors['tDocError'],
          //   onChanged: (value) {
          //     setState(() {
          //       tDoc = value;
          //     });
          //   },
          // ), // Aquí puedes agregar los campos del formulario
        ],
      ),
    );
  }
}
