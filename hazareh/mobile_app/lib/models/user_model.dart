class UserModel {
  final int id;
  final String name;
  final String? nationalId;
  final String? phone;
  final String? email;
  final String role;

  UserModel({required this.id, required this.name, this.nationalId,
    this.phone, this.email, required this.role});

  factory UserModel.fromJson(Map<String, dynamic> j) => UserModel(
    id: j['id'], name: j['name'], nationalId: j['national_id'],
    phone: j['phone'], email: j['email'], role: j['role'] ?? 'visitor',
  );

  String get roleLabel {
    const map = {'admin':'مدیر','student':'هنرجو','teacher':'دبیر',
      'counselor':'مشاور','judge':'داور','conference_admin':'مدیر همایش'};
    return map[role] ?? 'بازدیدکننده';
  }
}
