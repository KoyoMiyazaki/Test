from django.test import SimpleTestCase
from django.urls import reverse_lazy

class TestSiteLayout(SimpleTestCase):
    """サイトレイアウト用のテストクラス"""

    def test_layout_links(self):
        """サイト内のリンクを検証する"""
        response = self.client.get(reverse_lazy('micropost:static_pages_home'))
        self.assertTemplateUsed(response, 'static_pages/home.html')
        self.assertContains(response, 'href="{}"'.format(reverse_lazy('micropost:static_pages_home')), 2)
        self.assertContains(response, 'href="{}"'.format(reverse_lazy('micropost:static_pages_help')), 1)
        self.assertContains(response, 'href="{}"'.format(reverse_lazy('micropost:static_pages_about')), 1)
        self.assertContains(response, 'href="{}"'.format(reverse_lazy('micropost:static_pages_contact')), 1)
        self.assertContains(response, 'href="{}"'.format(reverse_lazy('micropost:users_signup')), 1)