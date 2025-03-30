import 'package:flutter/material.dart';
import '../../Domains/usecases/login_user.dart';

class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  @override
  void initState() {
    super.initState();
    _loadDocs();
  }

  // final TextEditingController tDocumentoController = TextEditingController();
  final TextEditingController numDocController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  final _formKey = GlobalKey<FormState>();
  String textNumDoc = '';
  int tDoc = 0;
  String password = '';
  ApiService apiService = ApiService();
  List<dynamic> docItems = [];

  Future<void> _loadDocs() async {
    final items = await apiService.getDoc();
    setState(() {
      docItems = items;
    });
  }

  void login(int tDoc, String numDoc, String password) {
    if (_formKey.currentState!.validate()) {
      setState(() {
        int numDoc = (int.parse(textNumDoc));
        apiService.apiLogin(tDoc, numDoc, password);
      });
    }
  }

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
                colors: [Color(0xFF12464C), Color(0xFF34E69F)],
              ),
            ),
            child: Padding(
              padding: const EdgeInsets.only(top: 20.0, left: 15.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  ElevatedButton(
                    onPressed: () {
                      Navigator.pop(context);
                    },
                    child: const Icon(Icons.arrow_back),
                  ),
                  const SizedBox(height: 10),
                  const Text(
                    '¡Hola,\nBienvenido! a Buzos Mt',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 20,
                      color: Colors.white,
                    ),
                  ),
                ],
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(top: 300.0),
            child: Container(
              height: double.infinity,
              width: double.infinity,
              decoration: const BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(30),
                  topRight: Radius.circular(30),
                ),
              ),
              child: Form(
                key: _formKey,
                child: Padding(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 18.0,
                    vertical: 30.0,
                  ),
                  child: Column(
                    children: [
                      DropdownButtonFormField<int>(
                        items:
                            docItems.map<DropdownMenuItem<int>>((item) {
                              return DropdownMenuItem<int>(
                                value: item['id_tipo_documento'],
                                child: Text(item['tip_doc_descripcion'].trim()),
                              );
                            }).toList(),

                        onChanged: (value) {
                          setState(() {
                            tDoc =
                                value!; // 🔹 Se actualiza la variable en lugar del controller
                          });
                        },
                        decoration: const InputDecoration(
                          floatingLabelStyle: TextStyle(
                            color: Color(0xFF12464C),
                          ),
                          labelText: 'Tipo de Documento',
                          prefixIcon: Icon(Icons.badge),
                        ),
                        validator: (value) {
                          if (value == null || value == 0) {
                            return 'Por favor seleccione un tipo de documento';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 10),
                      TextFormField(
                        controller: numDocController,
                        decoration: const InputDecoration(
                          labelText: 'Número de Documento',
                          floatingLabelStyle: TextStyle(
                            color: Color(0xFF12464C),
                          ),
                          prefixIcon: Icon(Icons.person),
                        ),
                        validator: (value) {
                          if (value == null || value == 0) {
                            return 'Por favor ingrese su número de documento';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 10),
                      TextFormField(
                        controller: passwordController,
                        decoration: const InputDecoration(
                          focusedBorder: UnderlineInputBorder(
                            borderSide: BorderSide(
                              color: Color(0xFF12464C),
                              width: 2.0,
                            ),
                          ),
                          labelText: 'Contraseña',
                          floatingLabelStyle: TextStyle(
                            color: Color(0xFF12464C),
                          ),
                          prefixIcon: Icon(Icons.lock),
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Por favor ingrese una contraseña';
                          }
                          return null;
                        },
                        obscureText: true,
                      ),
                      const SizedBox(height: 20),
                      Container(
                        height: 55,
                        width: double.infinity,
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(30),
                          color: const Color.fromARGB(255, 15, 52, 67),
                        ),
                        child: ElevatedButton(
                          style: ElevatedButton.styleFrom(
                            backgroundColor: Colors.transparent,
                            shadowColor: Colors.transparent,
                          ),
                          onPressed: () {
                            login(
                              tDoc,
                              numDocController.text,
                              passwordController.text,
                            );
                          },
                          child: const Text(
                            'Ingresar',
                            style: TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.bold,
                              fontSize: 20,
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
