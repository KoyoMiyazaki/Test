from django.test import TestCase
from django.urls import reverse_lazy

class BaseTestCase(TestCase):
    """各種テストクラスの基底クラス"""
    def setUp(self):
        """テストメソッド実行前の事前設定"""
        self.base_title = "Rails Tutorial Sample App"

class TestHomeView(BaseTestCase):
    """HomeView用のテストクラス"""

    def test_should_get_home(self):
        """Homeページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:home'))
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, '<title>Home | {}</title>'.format(self.base_title))

class TestHelpView(BaseTestCase):
    """HelpView用のテストクラス"""

    def test_should_get_help(self):
        """Helpページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:help'))
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, '<title>Help | {}</title>'.format(self.base_title))

class TestAboutView(BaseTestCase):
    """AboutView用のテストクラス"""

    def test_should_get_about(self):
        """Aboutページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:about'))
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, '<title>About | {}</title>'.format(self.base_title))

class TestContactView(BaseTestCase):
    """ContactView用のテストクラス"""

    def test_should_get_contact(self):
        """Contactページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:contact'))
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, '<title>Contact | {}</title>'.format(self.base_title))