import '../../Domains/models/etapa_model.dart';
import 'package:flutter/material.dart';

class EtapasScreen extends StatefulWidget {
  const EtapasScreen({super.key});

  @override
  State<EtapasScreen> createState() => _EtapasScreenState();
}

class _EtapasScreenState extends State<EtapasScreen> {
  // Definición de colores de la paleta
  final Color primaryColor = const Color(0xFF0D3D4A);
  final Color secondaryColor = const Color(0xFF20A67B);

  final TextEditingController nombreEtapaController = TextEditingController();
  final TextEditingController descripcionController = TextEditingController();
  Map<String, String> _errors = {};
  final keyForm = GlobalKey<FormState>();
  
  // Lista para almacenar las etapas (simulada)
  List<Etapa> etapas = [
    Etapa(etaNombre: "Preparación", etaDescripcion: "Fase inicial del proyecto"),
    Etapa(etaNombre: "Producción", etaDescripcion: "Desarrollo principal"),
    Etapa(etaNombre: "Control de calidad", etaDescripcion: "Verificación de estándares"),
  ];
  
  bool isEditing = false;
  int editingIndex = -1;

  void limpiarCampos() {
    nombreEtapaController.clear();
    descripcionController.clear();
    setState(() {
      isEditing = false;
      editingIndex = -1;
      _errors = {};
    });
  }

  // Método para validar los datos sin usar el EtapasUsecase
  Map<String, String> validarDatos(String nombre, String descripcion) {
    Map<String, String> errores = {};
    
    // Validación del nombre
    if (nombre.isEmpty) {
      errores['etaNombre'] = 'El nombre de la etapa es obligatorio';
    } else if (nombre.length < 3) {
      errores['etaNombre'] = 'El nombre debe tener al menos 3 caracteres';
    }
    
    // Validación de la descripción
    if (descripcion.isEmpty) {
      errores['etaDescripcion'] = 'La descripción es obligatoria';
    } else if (descripcion.length < 5) {
      errores['etaDescripcion'] = 'La descripción debe tener al menos 5 caracteres';
    }
    
    return errores;
  }

  void mostrarModalEtapa({Etapa? etapa, int? index}) {
    if (etapa != null) {
      nombreEtapaController.text = etapa.etaNombre ?? '';
      descripcionController.text = etapa.etaDescripcion ?? '';
      isEditing = true;
      editingIndex = index!;
    } else {
      limpiarCampos();
    }

    showDialog(
      context: context,
      builder: (BuildContext context) {
        return Dialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20.0),
          ),
          child: Container(
            constraints: BoxConstraints(
              maxHeight: MediaQuery.of(context).size.height * 0.5,
            ),
            child: Padding(
              padding: const EdgeInsets.all(24.0),
              child: Form(
                key: keyForm,
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text(
                          isEditing ? 'Editar Etapa' : 'Nueva Etapa',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: primaryColor,
                          ),
                        ),
                        IconButton(
                          icon: Icon(Icons.close, color: secondaryColor),
                          onPressed: () => Navigator.pop(context),
                        ),
                      ],
                    ),
                    const SizedBox(height: 24),
                    TextFormField(
                      controller: nombreEtapaController,
                      decoration: InputDecoration(
                        labelText: 'Nombre de la etapa',
                        labelStyle: TextStyle(color: primaryColor),
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                        focusedBorder: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                          borderSide: BorderSide(color: secondaryColor, width: 2),
                        ),
                        prefixIcon: Icon(Icons.label_outline, color: secondaryColor),
                        errorText: _errors['etaNombre'],
                      ),
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Por favor ingrese un nombre';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 20),
                    TextFormField(
                      controller: descripcionController,
                      decoration: InputDecoration(
                        labelText: 'Descripción',
                        labelStyle: TextStyle(color: primaryColor),
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                        focusedBorder: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                          borderSide: BorderSide(color: secondaryColor, width: 2),
                        ),
                        prefixIcon: Icon(Icons.description_outlined, color: secondaryColor),
                        errorText: _errors['etaDescripcion'],
                      ),
                      maxLines: 3,
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Por favor ingrese una descripción';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 30),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.end,
                      children: [
                        OutlinedButton(
                          onPressed: () {
                            limpiarCampos();
                            Navigator.pop(context);
                          },
                          style: OutlinedButton.styleFrom(
                            foregroundColor: primaryColor,
                            side: BorderSide(color: primaryColor),
                            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 15),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(10),
                            ),
                          ),
                          child: const Text('Cancelar'),
                        ),
                        const SizedBox(width: 15),
                        ElevatedButton(
                          onPressed: () {
                            guardarEtapa();
                            Navigator.pop(context);
                          },
                          style: ElevatedButton.styleFrom(
                            backgroundColor: secondaryColor,
                            foregroundColor: Colors.white,
                            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 15),
                            elevation: 3,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(10),
                            ),
                          ),
                          child: Row(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              const Icon(Icons.save),
                              const SizedBox(width: 8),
                              Text(isEditing ? 'Actualizar' : 'Guardar'),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        );
      },
    );
  }

  void guardarEtapa() {
    FocusScope.of(context).unfocus();
    if (keyForm.currentState!.validate()) {
      // Aquí reemplazamos la validación del usecase por nuestra propia validación
      final Map<String, String> errors = validarDatos(
        nombreEtapaController.text,
        descripcionController.text
      );
      
      setState(() {
        _errors = errors;
      });
      
      if (_errors.isEmpty) {
        // Si no hay errores, guardar la etapa
        if (isEditing && editingIndex >= 0) {
          // Actualizar la etapa existente
          setState(() {
            etapas[editingIndex] = Etapa(
              etaNombre: nombreEtapaController.text,
              etaDescripcion: descripcionController.text,
            );
          });
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: const Text('Etapa actualizada con éxito'),
              backgroundColor: secondaryColor,
              behavior: SnackBarBehavior.floating,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
            ),
          );
        } else {
          // Agregar nueva etapa
          setState(() {
            etapas.add(Etapa(
              etaNombre: nombreEtapaController.text,
              etaDescripcion: descripcionController.text,
            ));
          });
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: const Text('Etapa guardada con éxito'),
              backgroundColor: secondaryColor,
              behavior: SnackBarBehavior.floating,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
            ),
          );
        }
        limpiarCampos();
      }
    }
  }

  void eliminarEtapa(int index) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('Confirmar eliminación', style: TextStyle(color: primaryColor)),
          content: const Text('¿Estás seguro de que deseas eliminar esta etapa?'),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15),
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              style: TextButton.styleFrom(
                foregroundColor: primaryColor,
              ),
              child: const Text('Cancelar'),
            ),
            ElevatedButton(
              onPressed: () {
                setState(() {
                  etapas.removeAt(index);
                });
                Navigator.pop(context);
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: const Text('Etapa eliminada'),
                    backgroundColor: Colors.red.shade700,
                    behavior: SnackBarBehavior.floating,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(10),
                    ),
                  ),
                );
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.red.shade600,
                foregroundColor: Colors.white,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10),
                ),
              ),
              child: const Text('Eliminar'),
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Etapas de Producción'),
        elevation: 0,
        backgroundColor: Color(0xFF0D3D4A),
        foregroundColor: Colors.white,
      ),
      backgroundColor: Colors.grey.shade100,
      floatingActionButton: FloatingActionButton(
        onPressed: () => mostrarModalEtapa(),
        backgroundColor: secondaryColor,
        elevation: 4,
        child: const Icon(Icons.add, color: Colors.white),
      ),
      body: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Contador de etapas (ahora en la parte superior sin el encabezado)
          Padding(
            padding: const EdgeInsets.fromLTRB(20, 20, 20, 10),
            child: Row(
              children: [
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                  decoration: BoxDecoration(
                    color: secondaryColor.withOpacity(0.2),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: Row(
                    children: [
                      Icon(Icons.layers, size: 16, color: secondaryColor),
                      const SizedBox(width: 6),
                      Text(
                        '${etapas.length} etapas',
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          color: secondaryColor,
                        ),
                      ),
                    ],
                  ),
                ),
                const Spacer(),
                TextButton.icon(
                  onPressed: () => mostrarModalEtapa(),
                  icon: Icon(Icons.add_circle, color: secondaryColor),
                  label: Text(
                    'Nueva Etapa',
                    style: TextStyle(color: secondaryColor),
                  ),
                ),
              ],
            ),
          ),
          
          // Lista de etapas
          Expanded(
            child: etapas.isEmpty
                ? Center(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(
                          Icons.layers_clear,
                          size: 60,
                          color: primaryColor.withOpacity(0.3),
                        ),
                        const SizedBox(height: 16),
                        Text(
                          'No hay etapas registradas',
                          style: TextStyle(
                            color: primaryColor.withOpacity(0.6),
                            fontSize: 16,
                          ),
                        ),
                        const SizedBox(height: 8),
                        TextButton.icon(
                          onPressed: () => mostrarModalEtapa(),
                          icon: Icon(Icons.add, color: secondaryColor),
                          label: Text(
                            'Agregar etapa',
                            style: TextStyle(color: secondaryColor),
                          ),
                        ),
                      ],
                    ),
                  )
                : ListView.builder(
                    padding: const EdgeInsets.all(16),
                    itemCount: etapas.length,
                    itemBuilder: (context, index) {
                      final etapa = etapas[index];
                      return Padding(
                        padding: const EdgeInsets.only(bottom: 12),
                        child: Card(
                          elevation: 2,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(15),
                          ),
                          child: InkWell(
                            borderRadius: BorderRadius.circular(15),
                            onTap: () => mostrarModalEtapa(etapa: etapa, index: index),
                            child: Container(
                              padding: const EdgeInsets.all(16),
                              child: Row(
                                children: [
                                  // Avatar con la inicial
                                  Container(
                                    width: 50,
                                    height: 50,
                                    decoration: BoxDecoration(
                                      gradient: LinearGradient(
                                        colors: [primaryColor, secondaryColor],
                                        begin: Alignment.topLeft,
                                        end: Alignment.bottomRight,
                                      ),
                                      borderRadius: BorderRadius.circular(12),
                                    ),
                                    child: Center(
                                      child: Text(
                                        etapa.etaNombre?[0].toUpperCase() ?? '?',
                                        style: const TextStyle(
                                          color: Colors.white,
                                          fontSize: 22,
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                  ),
                                  const SizedBox(width: 16),
                                  // Información de la etapa
                                  Expanded(
                                    child: Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          etapa.etaNombre ?? 'Sin nombre',
                                          style: const TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 16,
                                          ),
                                        ),
                                        const SizedBox(height: 4),
                                        Text(
                                          etapa.etaDescripcion ?? 'Sin descripción',
                                          style: TextStyle(
                                            color: Colors.grey.shade600,
                                            fontSize: 14,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                  // Botones de acción
                                  IconButton(
                                    icon: Icon(Icons.edit_outlined, color: primaryColor),
                                    onPressed: () => mostrarModalEtapa(etapa: etapa, index: index),
                                    tooltip: 'Editar',
                                  ),
                                  IconButton(
                                    icon: const Icon(Icons.delete_outline, color: Colors.red),
                                    onPressed: () => eliminarEtapa(index),
                                    tooltip: 'Eliminar',
                                  ),
                                ],
                              ),
                            ),
                          ),
                        ),
                      );
                    },
                  ),
          ),
        ],
      ),
    );
  }
}