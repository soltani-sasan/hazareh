class AnnouncementModel {
  final int id;
  final String title;
  final String body;
  final String section;
  final String? createdAt;

  AnnouncementModel({required this.id, required this.title,
    required this.body, required this.section, this.createdAt});

  factory AnnouncementModel.fromJson(Map<String, dynamic> j) => AnnouncementModel(
    id: j['id'], title: j['title'], body: j['body'] ?? '',
    section: j['section'] ?? 'educational', createdAt: j['created_at'],
  );

  String get sectionLabel {
    const map = {'educational':'آموزشی','counseling':'مشاوره‌ای','nurturing':'پرورشی'};
    return map[section] ?? section;
  }
}
