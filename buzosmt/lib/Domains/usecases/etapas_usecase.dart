import '../models/etapa_model.dart';

class EtapasUsecase {
  final Etapa etapa;
  EtapasUsecase(this.etapa);
  Map<String, String> dataValidate() {
    if (etapa.etaId == null || etapa.etaId == 0) {
      return {'etaIdError': 'ID de etapa requerido o inválido'};
    }
    if (etapa.etaNombre == null || etapa.etaNombre!.isEmpty) {
      return {'etaNombreError': 'Nombre de etapa requerido'};
    }
    if (etapa.etaDescripcion == null || etapa.etaDescripcion!.isEmpty) {
      return {'etaDescripcionError': 'Descripción de etapa requerida'};
    }
    if (etapa.etaNombre!.length > 50) {
      return {
        'etaNombreError':
            'El nombre de la etapa no puede tener más de 50 caracteres',
      };
    }
    if (etapa.etaDescripcion!.length > 200) {
      return {
        'etaDescripcionError':
            'La descripción de la etapa no puede tener más de 200 caracteres',
      };
    }
    return {}; // Sin errores
  }
}
