class NewsModel {
  final int id;
  final String title;
  final String slug;
  final String body;
  final String? image;
  final String category;
  final String grade;
  final String type;
  final String? publishedAt;

  NewsModel({required this.id, required this.title, required this.slug,
    required this.body, this.image, required this.category,
    required this.grade, required this.type, this.publishedAt});

  factory NewsModel.fromJson(Map<String, dynamic> j) => NewsModel(
    id: j['id'], title: j['title'], slug: j['slug'],
    body: j['body'] ?? '', image: j['image'],
    category: j['category'] ?? 'general', grade: j['grade'] ?? 'all',
    type: j['type'] ?? 'news', publishedAt: j['published_at'],
  );

  String get categoryLabel {
    const map = {'electrical':'برق صنعتی','mechanical':'تاسیسات مکانیکی',
      'instrumentation':'ابزار دقیق','extra':'فوق‌برنامه'};
    return map[category] ?? 'عمومی';
  }
}
