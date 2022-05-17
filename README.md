# 검색 치환 플러그인

PHP 소스를 분석하여 좀 더 스마트하게 검색 치환을 해 보자.

## 검색 치환 대상

1. 클래스 이름
2. 함수 이름
3. 일반 문자열. 모든 문자열에 대해 특정 패턴.
4. 특정 함수의 특정 인자.
   * __()
   * _e()
   * _ex()
   * _n()
   * _n_noop()
   * _nx()
   * _nx_noop()
   * _x()
   * esc_attr__()
   * esc_attr_e()
   * esc_attr_x()
   * esc_html__()
   * esc_html_e()
   * esc_html_x()
